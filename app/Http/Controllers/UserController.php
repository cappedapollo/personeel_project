<?php

namespace App\Http\Controllers;

use App;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Mail;
use PDF;
use Google2FA;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $page_title = __('form.label.dashboard');
        $user_id = Auth::id();
        $role_code = Auth::user()->user_role->role_code;
        $ids = $user_ids = $_archives = collect();
        $manager_id = $selected_year = $review_type_id = '';
        $form_data_btn = __('form.array.form_data_btn');
        $current_year = date('Y');
        $logs = collect();
        
        if($role_code == 'admin') {
            $user_ids = Auth::user()->users->pluck('id');
        }elseif($role_code == 'manager') {
            $user_id = '';
            $manager_id = Auth::id();
            $user_ids = Auth::user()->employees->pluck('id');
        }
        
        if($user_ids) {
            /* $archive_ids = App\Models\Archive::whereIn('user_id', $user_ids)->pluck('id');
            $ids = $user_ids->concat($archive_ids);
            
            $form_data_ids = App\Models\FormData::whereIn('user_id', $user_ids)->pluck('id');
            $ids = $user_ids->concat($form_data_ids); */
            
            
            $logs = App\Models\Log::where('module', 'user')->whereIn('module_id', $user_ids)->orderBy('id', 'desc')->get();
            
            $archive_ids = App\Models\Archive::whereIn('user_id', $user_ids)->pluck('id');
            $archive_logs = App\Models\Log::where('module', 'archive')->whereIn('module_id', $archive_ids)->orderBy('id', 'desc')->get();
            $logs = $logs->merge($archive_logs)->sortDesc();
            
            $form_data_ids = App\Models\FormData::whereIn('user_id', $user_ids)->pluck('id');
            $form_data_logs = App\Models\Log::where('module', 'form_data')->whereIn('module_id', $form_data_ids)->orderBy('id', 'desc')->get();
            $logs = $logs->merge($form_data_logs)->sortDesc();
            $logs = $logs->take(8);
        }
        
        /* $logs = App\Models\Log::when($ids, function ($query, $ids) {
            $query->whereIn('module_id', $ids)->whereIn('module', ['form_data', 'archive']);
        })->orderBy('id', 'desc')->limit(8)->get(); */
        
        $field = 'role_'.app()->getLocale();
        $user_roles = App\Models\UserRole::orderBy($field, 'asc')->get();
        
        $users = User::has('form')->get();
        if ($users->count()>0)
        {
            if ($user_id)
            {
                $users = $users->filter(function ($item) use($user_id) {
                    return $item->created_by == $user_id || $item->id === $user_id;
                });
            }
            if ($manager_id)
            {
                $users = $users->filter(function ($item) use($manager_id) {
                    return $item->manager_id == $manager_id;
                });
            }
        }
        
        $_users = User::when($user_id, function ($query, $user_id) {
                $query->where('created_by', $user_id)->orWhere('id', $user_id);
            })
            ->when($manager_id, function ($query, $manager_id) {
                $query->where('manager_id', $manager_id);
            })->get();
        $user_counts = $_users->countBy(function ($item) {
            return $item->user_role->role_code;
        });
        
        if($role_code == 'employee') {
            $archives = App\Models\Archive::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        }else {
            $archives = App\Models\Archive::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
            $_archives = App\Models\Archive::whereIn('user_id', $user_ids)->where('status', 'pending')->orderBy('created_at', 'desc')->limit(8)->get();
        }
        
        if ($request->isMethod('post')) {
            if ($request->filled('review_type_id')) {
                $selected_year = $request->year;
                $review_type_id = $request->review_type_id;
            }
        }
        
        $yearly_review_types = App\Models\ReviewType::with(['form_data' => function($query) use($user_ids)
            {
                $query->whereHas('user', function($query) use($user_ids) {
                    $query->whereIn('id', $user_ids);
                })->withCount([
                    'archive as pending_archive' => function ($query) {
                        $query->where('status', 'pending');
                    },
                    'archive as reviewed_archive' => function ($query) {
                        $query->where('status', 'reviewed');
                    },
                    'archive as not_sign_count' => function ($query) {
                        $query->where('content', '')->where('status', 'pending');
                    },
                    'archive as agree_count' => function ($query) {
                        $query->where('content', 'read')->where('status', 'pending');
                    },
                    'archive as took_note_count' => function ($query) {
                        $query->where('content', 'note')->where('status', 'pending');
                    }
                ]);
            }])->whereIn('number', array_keys($form_data_btn))->orderBy('number', 'asc')->get();
        
        # merge years and get by selected year
        foreach($yearly_review_types as $key=>$review_type)
        {
            $_review_type = company_review_type($review_type->number);
            $yearly_review_types[$key]['name'] = $_review_type->name;
            
            if($review_type->form_data->count() > 0) {
                $years = $review_type->form_data->pluck('year');
                $years->push($current_year);
                $years = $years->unique()->sort()->toArray();
                $latest_year = ($selected_year && $review_type_id==$review_type->id) ? $selected_year : $current_year;
                $yearly_review_types[$key]['years'] = $years;
            } else {
                $latest_year = $current_year;
                $yearly_review_types[$key]['years'] = array($current_year);
            }
            
            $yearly_review_types[$key]['selected_year'] = $latest_year;
            $form_data = $review_type->form_data->where('year', $latest_year);
            $review_type->setRelation('form_data', $form_data);
            $pending_count = $reviewed_count = $not_sign_count = $agree_count = $took_note_count = 0;
            foreach ($review_type->form_data as $_form_data)
            {
                $pending_count += $_form_data->pending_archive;
                $reviewed_count += $_form_data->reviewed_archive;
                $not_sign_count += $_form_data->not_sign_count;
                $agree_count += $_form_data->agree_count;
                $took_note_count += $_form_data->took_note_count;
            }
            $yearly_review_types[$key]['pending_archive'] = $pending_count;
            $yearly_review_types[$key]['reviewed_archive'] = $reviewed_count;
            $yearly_review_types[$key]['not_sign_count'] = $not_sign_count;
            $yearly_review_types[$key]['agree_count'] = $agree_count;
            $yearly_review_types[$key]['took_note_count'] = $took_note_count;
            
            unset($yearly_review_types[$key]['form_data']);
        }
        
        return view('users.dashboard', compact('page_title', 'users', 'user_counts', 'logs', 'user_roles', 'field', 'archives', 'form_data_btn', 'yearly_review_types', 'role_code', '_archives'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        checkAuthorization(['superadmin', 'admin', 'manager']);
        $page_title = trans_choice('menu.user', 2);
        $role_code = Auth::user()->user_role->role_code;
        $user_id = $rcode = ($role_code == 'superadmin') ? '' : Auth::id();
        $user_ids = array();
        $manager_id = '';
        $managers = $users_to_link = collect();
        $company_id = '';
        if (Auth::user()->company_user)
        {
            $company_id = Auth::user()->company_user->company_id;
        }
        if ($role_code == 'manager') 
        {
            $user_id = '';
            $manager_id = Auth::id();
            $user = User::find($manager_id);
            $user_ids = $user->get_user_tree($user);
            if (($key = array_search($manager_id, $user_ids)) !== false) {
                unset($user_ids[$key]);
            }
        }
        elseif ($role_code == 'admin') 
        {
            $user_ids = Auth::user()->company_user->company->company_user->pluck('user_id');
        }
        
        $users = User::when($rcode, function ($query) use($user_ids) {
            $query->whereIn('id', $user_ids);
        })->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();
        
        if ($user_id) {
            $linked_managers = $users->whereNotNull('manager_id')->pluck('manager_id')->unique();
            $managers = $users->filter(function ($value, $key) {
                return ( in_array($value->user_role->role_code, ['admin', 'manager']) );
            });
            $managers = $managers->mapWithKeys(function ($item) {
                return [$item['id'] => $item['first_name'].' '.$item['last_name']];
            });
            
            $users_to_link = $users->filter(function ($value, $key) {
                return in_array($value->user_role->role_code, ['admin', 'manager']);
            });
            $users_to_link = $users_to_link->mapWithKeys(function ($item) {
                return [$item['id'] => $item['first_name'].' '.$item['last_name']];
            });
        }
        
        $field = 'role_'.app()->getLocale();
        $user_roles = App\Models\UserRole::whereNotIn('role_code', ['superadmin'])->orderBy($field, 'asc')->get();
        
        $review_types = App\Models\ReviewType::orderBy('number', 'asc')->get();
        foreach ($review_types as $review_type)
        {
            if ($company_id)
            {
                if ($review_type->company_review_type)
                {
                    $company_review_type = $review_type->company_review_type->firstWhere([['company_id', $company_id], ['review_type_id', $review_type->id]]);
                    if ( $company_review_type )
                    {
                        $review_type['name'] = $company_review_type->name;
                    }
                }
            }
        }
        
        return view('users.index', compact('page_title', 'users', 'managers', 'user_roles', 'review_types', 'users_to_link'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        checkAuthorization(['manager', 'admin']);
        $page_title = trans_choice('form.label.add', 1).' '.trans_choice('menu.user', 1);
        $role_code = Auth::user()->user_role->role_code;
        $manager_id = '';
        $user_id = ($role_code == 'superadmin') ? '' : Auth::id();
        $field = 'role_'.app()->getLocale();
        $user_roles = App\Models\UserRole::whereNotIn('role_code', ['superadmin'])->orderBy($field, 'asc')->get();
        if ($role_code == 'admin')
        {
            $user_ids = Auth::user()->company_user->company->company_user->pluck('user_id');
        }
        elseif ($role_code == 'manager')
        {
            $user_id = '';
            $manager_id = Auth::id();
        }
        
        $managers = User::whereHas('user_role', function($query) {
            $query->whereIn('role_code', ['admin', 'manager']);
        })->when($user_id, function ($query) use($user_ids) {
            $query->whereIn('id', $user_ids);
        })->when($manager_id, function ($query, $manager_id) {
            $query->where('manager_id', $manager_id);
        })->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();
        $managers = $managers->mapWithKeys(function ($item) {
            return [$item['id'] => $item['first_name'].' '.$item['last_name']];
        });
        
        return view('users.create', compact('page_title', 'user_roles', 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email_found = User::where('email', $request->input('email'))->first();
        if ($email_found) {
            return redirect()->back()->with('error', __('messages.email_exist'))->withInput();
        }else{
            $user_role = App\Models\UserRole::firstWhere('role_code', 'employee');
            $created_by = Auth::id();
            $company_id = Auth::user()->company_user->company_id;
            $status = $request->input('status');
            $password = getRandomString(8);
            $request['created_by'] = $created_by;
            $request['password'] = Hash::make($password);
            $request['email_verified'] = 'yes';
            # add google2fa_secret value
            $request["google2fa_secret"] = Google2FA::generateSecretKey();
            
            if($inserted_data = User::create($request->except(['_token']))) {
                # add company user data
                $cu_data['company_id'] = $company_id;
                $cu_data['user_id'] = $inserted_data->id;
                App\Models\CompanyUser::create($cu_data);
                
                # send temporary password
                if ($status == 'active' && $user_role->id != $request->user_role_id) {
                    $mail_data = ['email'=>$inserted_data->email, 'password'=>$password];
                    Mail::send('emails.'.app()->getLocale().'.user_registered', compact('mail_data'), function($message) use ($mail_data) {
                        $message->to($mail_data['email'])->subject(__('email.subject.user_registered'));
                    });
                }
        
                return redirect(app()->getLocale().'/users')->with('success', trans_choice('menu.user', 1).' '.trans_choice('messages.saved', 1));
            }else{
                return redirect()->back()->with('error', __('messages.processing_err'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        checkAuthorization(['superadmin', 'admin']);
        $id = $request->segment(3);
        $user = User::find($id);
        $page_title = trans_choice('menu.user', 1).': '.$user->full_name;
        return view('users.show', compact('page_title', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        checkAuthorization(['superadmin', 'admin']);
        $page_title = __('form.label.update').' '.trans_choice('menu.user', 1);
        $role_code = Auth::user()->user_role->role_code;
        $user_id = ($role_code == 'superadmin') ? '' : Auth::id();
        $manager_id = '';
        $id = $request->segment(3);
        $user = User::find($id);
        $field = 'role_'.app()->getLocale();
        $user_roles = App\Models\UserRole::whereNotIn('role_code', ['superadmin'])->orderBy($field, 'asc')->get();
        
        $user_ids = collect();
        if ($role_code == 'admin')
        {
            $user_ids = Auth::user()->company_user->company->company_user->pluck('user_id');
        }
        elseif ($role_code == 'manager')
        {
            $user_id = '';
            $manager_id = Auth::id();
        }
        
        $managers = User::whereHas('user_role', function($query) {
            $query->whereIn('role_code', ['admin', 'manager']);
        })->when($user_id, function ($query) use($user_ids) {
            $query->whereIn('id', $user_ids);
        })->when($manager_id, function ($query, $manager_id) {
            $query->where('manager_id', $manager_id);
        })->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();
        $managers = $managers->mapWithKeys(function ($item) {
            return [$item['id'] => $item['first_name'].' '.$item['last_name']];
        });
        
        return view('users.edit', compact('page_title', 'user', 'user_roles', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $request->segment(3);
        $user = User::find($id);
        
        # admin emails
        $user_ids = $user->company_user->company->company_user->pluck('user_id');
        $user_emails = User::whereIn('id', $user_ids)->whereHas('user_role', function($query) {
            $query->where('role_code', 'admin');
        })->pluck('email', 'id');
        $user_emails->put($id, $user->email);
        
        $except = array('_token', '_method');
        $data = $request->except($except);
        if(User::where('id', $id)->update($data)) {
            $updated_user = User::find($id);
            if ($user->user_role_id != $updated_user->user_role_id)
            {
                # If Admin changes role of an existing user, then send confirmation email to all Admins AND user
                foreach ($user_emails as $user_email)
                {
                    $mail_data = ['email'=>$user_email, 'user'=>$user, 'updated_user'=>$updated_user];
                    Mail::send('emails.'.app()->getLocale().'.userrole_changed', compact('mail_data'), function($message) use ($mail_data) {
                        $message->to($mail_data['email'])->subject(__('email.subject.userrole_changed'));
                    });
                }
            }
            
            return redirect()->back()->with('success', trans_choice('menu.user', 1).' '.trans_choice('messages.updated', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->segment(3);
        $user = User::find($id);
        if($user->delete()) {
            return redirect()->back()->with('success', trans_choice('menu.user', 1).' '.trans_choice('messages.deleted', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
    
    public function login() {
        $page_title = __('form.label.sign_in');
        return view('users.login', compact('page_title'));
    }
    
    public function authenticate(Request $request) {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'status'=>'active', 'email_verified'=>'yes'])) {
            $request->session()->regenerate();
            $user = Auth::user();
            $role_code = Auth::user()->user_role->role_code;
            $redirect = app()->getLocale().'/verify';
            
            if($role_code == 'employee') 
            {
                $redirect = app()->getLocale().'/';
                if (Auth::user()->first_login == 1) {
                    $redirect = app()->getLocale().'/profile';
                }
            }
            else 
            {
                if (Auth::user()->first_login == 1) {
                    $user->gfa_setup = 1;
                    $user->gfa_authenticated = 0;
                    $user->save();
                    $redirect = app()->getLocale().'/gfa_register';
                }
            }
            return redirect($redirect);
        }
    
        return redirect()->back()->with('error', __('messages.invalid_login'));
    }
    
    public function logout(Request $request) {
        $data['gfa_authenticated'] = 0;
        User::where('id', Auth::id())->update($data);
        Google2FA::logout();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(app()->getLocale().'/login');
    }
    
    public function profile(Request $request) {
        $page_title = __('form.label.my_profile');
        $user = User::find(Auth::id());
    
        if ($request->isMethod('post')) {
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'required|confirmed'
                ]);
                
                $request['password'] = Hash::make($request->password);
                $request['first_login'] = 0;
            }else{
                unset($request['password']);
            }
            
            $email_found = User::where('id', '!=', Auth::id())->where('email', $request->input('email'))->first();
            if ($email_found) {
                return redirect()->back()->with('error', __('messages.email_exist'));
            }else{
                $data = $request->except(['_token', 'password_confirmation']);
                if(User::where('id', Auth::id())->update($data)) {
                    # refresh auth seesion with updated data
                    $request->session()->regenerate();
    
                    return redirect(app()->getLocale().'/profile')->with('success', __('form.label.profile').' '.trans_choice('messages.updated', 1));
                }else{
                    return redirect()->back()->with('error', __('messages.processing_err'));
                }
            }
        }
    
        return view('users.profile', compact('page_title', 'user'));
    }
    
    public function forgot_password(Request $request) {
        $user = User::where('status','active')->where('email',$request->input('email'))->first();
        if (!$user) {
            return redirect()->back()->with('error', __('messages.email_inactive'));
        }else{
            $_data['token'] = strtotime("now");
            if(User::where('id', $user->id)->update($_data)) {
                # send mail to reset password
                $data = ['name'=>$user->full_name, 'reset_url'=>config("app.url").app()->getLocale().'/reset_password/'.$_data['token']];
                Mail::send('emails.'.app()->getLocale().'.reset_password', compact('user', 'data'), function($message) use ($user) {
                    $message->to($user->email)->subject(__('email.subject.reset_password'));
                });
    
                return redirect(app()->getLocale().'/login')->with('success', __('messages.forget_password'));
            }
        }
    }
    
    public function reset_password(Request $request) {
        $page_title = __('form.label.reset_password');
        $token = $request->segment(3);
        if ($request->isMethod('post')) {
            $token = $request->input('token');
            /* $email = $request->input('email');
            $user = User::where('token', $token)->where('email', $email)->first(); */
            $user = User::where('token', $token)->where('status', 'active')->first();
            if ($user) {
                $start_datetime = new \DateTime(date('Y-m-d H:i:s', $token));
                $end_datetime = new \DateTime("now");
                $date_diff = $start_datetime->diff($end_datetime);
                 
                $_hours = $_minutes = $_seconds = 0;
                $hours = $date_diff->h;
                $minutes = $date_diff->i;
                $seconds = $date_diff->s;
                $hours = $hours + ($date_diff->days * 24);
                 
                $_seconds += $hours * 3600;
                $_seconds += $minutes * 60;
                $_seconds += $seconds;
                 
                $_hours = floor($_seconds / 3600);
                $_seconds -= $_hours * 3600;
                $_minutes  = floor($_seconds / 60);
                $_seconds -= $_minutes * 60;
                 
                if($_hours >= 1) {
                    return redirect()->back()->with('error', __('messages.link_expired'));
                }else{
                    $data['password'] = Hash::make($request->input('password'));
                    $data['token'] = '';
                    if(User::where('id', $user->id)->update($data)) {
                        return redirect(app()->getLocale().'/login')->with('success', __('messages.password_reset'));
                    }
                }
            }else{
                return redirect()->back()->with('error', __('messages.invalid_link'));
            }
        }
    
        return view('users.reset_password', compact('page_title', 'token'));
    }
    
    public function supdate(Request $request) {
        $id = $request->segment(3);
        $status = 'active';
        $user = User::find($id);
        $password = getRandomString(8);
        $user->password = Hash::make($password);
        $user->status = $status;
        if($user->save()) {
            if($status == 'active') {
                $mail_data = ['email'=>$user->email, 'password'=>$password];
                Mail::send('emails.'.app()->getLocale().'.user_activated', compact('mail_data'), function($message) use ($mail_data) {
                    $message->to($mail_data['email'])->subject(__('email.subject.user_activated'));
                });
            }
            return redirect()->back()->with('success', __('form.label.status').' '.trans_choice('messages.updated', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
    
    public function update_mng(Request $request) {
        $data['manager_id'] = $request->manager_id;
        $user_ids = explode(',', $request->user_ids);
        foreach ($user_ids as $user_id) {
            if($user_id) {
                User::where('id', $user_id)->update($data);
            }
        }
    
        return redirect(app()->getLocale().'/users')->with('success', trans_choice('menu.user', 2).' '.trans_choice('messages.updated', 2));
    }
    
    public function employees()
    {
        checkAuthorization(['admin', 'manager']);
        $page_title = __('form.label.my').' '.trans_choice('menu.user', 2);
        $user_id = Auth::id();
        $company_id = '';
        if (Auth::user()->company_user)
        {
            $company_id = Auth::user()->company_user->company_id;
        }
        
        $users = User::where('manager_id', $user_id)->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();
        
        $review_types = App\Models\ReviewType::orderBy('number', 'asc')->get();
        foreach ($review_types as $review_type)
        {
            if ($company_id)
            {
                if ($review_type->company_review_type)
                {
                    $company_review_type = $review_type->company_review_type->firstWhere([['company_id', $company_id], ['review_type_id', $review_type->id]]);
                    if ( $company_review_type )
                    {
                        $review_type['name'] = $company_review_type->name;
                    }
                }
            }
        }
        
        return view('users.employees', compact('page_title', 'users', 'review_types'));
    }
    
    /* public function pdf(Request $request) {
        checkAuthorization(['manager', 'admin']);
        $user_id = $request->segment(3);
        $review_type_num = $request->segment(4);
        
        $user = User::find($user_id);
        $form = $user->form;
        $lang = (Auth::user()->company_user) ? Auth::user()->company_user->company->language : app()->getLocale();
        $category_ids = $form_data = array();
        $form_data_btn = __('form.array.form_data_btn');
        
        if($form) {
            $category_ids = unserialize($form->category_ids);
            $sub_category_ids = unserialize($form->sub_category_ids);
            $form_data = $user->form_data;
        }
        $categories = App\Models\Category::whereIn('id', $category_ids)->get();
        $sub_categories = App\Models\SubCategory::whereIn('id', $sub_category_ids)->get();
        
        $action = 'Created scoresheet [user_name]';
        $review_type = $form_data_btn[$review_type_num]['txt_hover'];
        $action .= ', review type: '.$review_type;
        # add log
        App\Models\Log::create(['module_id'=>$user_id, 'action_by'=>Auth::id(), 'action'=>$action, 'module'=>'user']);
        
        $filename = 'performance_interview_'.date('dmYHi').'.pdf';
        $attachment_data = ['user'=>$user, 'categories'=>$categories, 'form_data'=>$form_data, 'form'=>$form, 'lang'=>$lang, 'review_type_num'=>$review_type_num, 'sub_categories'=>$sub_categories, 'type'=>''];
        $pdf = PDF::loadView('pdfs/en/performance_interview', $attachment_data);
        return $pdf->download($filename);
    } */
    
    /* public function add_gfa_secret() {
        $users = User::where('google2fa_secret', NULL)->get();
        foreach ($users as $user) {
            # add google2fa_secret value
            #$google2fa = app('pragmarx.google2fa');
            $user->google2fa_secret = Google2FA::generateSecretKey();
            $user->save();
        }
    } */
    
    public function support(Request $request) {
        $page_title = __('menu.support');
    
        if ($request->isMethod('post'))
        {
            $user = Auth::user();
            $to = env('SUPPORT_MAIL_TO');
            
            $mail_data = ['email'=>$to, 'message'=>$request->support, 'user'=>$user];
            Mail::send('emails.'.app()->getLocale().'.support', compact('mail_data'), function($message) use ($mail_data) {
                $message->to($mail_data['email'])->subject( __('email.subject.support') );
            });
            
            return redirect()->back()->with('success', __('form.label.message').' '.trans_choice('messages.sent', 1));
        }
        return view('users.support', compact('page_title'));
    }
}
