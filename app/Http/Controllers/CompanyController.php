<?php

namespace App\Http\Controllers;

use App;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Mail;
use Google2FA;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        checkAuthorization(['superadmin']);
        $page_title = trans_choice('menu.company', 2);
        $companies = Company::orderBy('created_at', 'desc')->get();
        
        return view('companies.index', compact('page_title', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = __('form.label.registration');
        $countries = App\Models\Country::orderBy('name', 'asc')->pluck('name', 'id');
        $n_employees = App\Models\EmployeeNo::orderBy('created_at', 'asc')->pluck('nos', 'id');
        return view('companies.create', compact('page_title', 'countries', 'n_employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_role = App\Models\UserRole::firstWhere('role_code', 'admin');
        $email_found = App\Models\User::where('email', $request->input('email'))->get('id')->first();
        if ($email_found) {
            return redirect()->back()->with('error', __('messages.email_exist'))->withInput();
        }else{
            $logo = '';
            $password = getRandomString(8);
            $user_data['user_role_id'] = $user_role->id;
            $user_data['created_by'] = Auth::check() ? Auth::id() : Null;
            $user_data['first_name'] = $request->first_name;
            $user_data['last_name'] = $request->last_name;
            $user_data['email'] = $request->email;
            $user_data['password'] = Hash::make($password);
            $user_data['country_code'] = $request->country_code;
            $user_data['telephone'] = $request->telephone;
            $user_data['function'] = $request->function;
            $user_data['status'] = 'inactive';
            $user_data['email_verified'] = 'yes';
            # add google2fa_secret value
            $user_data["google2fa_secret"] = Google2FA::generateSecretKey();
        
            $except = array_keys($user_data);
            array_push($except, '_token');
        
            # upload logo
            if($request->file('logo')) {
                $file = $request->file('logo');
                $file_name = generateFileName($file->getClientOriginalName());
                $file_key = getRandomString(5).date('dmYHis').'.'.$file->extension();
                $mime_type = $file->getClientMimeType();
                uploadToBucket($file->getPathname(), $file_key);
                
                # insert into files table
                $fdata['file_name'] = $file_name;
                $fdata['file_key'] = $file_key;
                $fdata['mime_type'] = $mime_type;
                $inserted_fdata = App\Models\File::create($fdata);
                $logo = $inserted_fdata->id;
            }
            
            $company_data = $request->except($except);
            $company_data['logo'] = $logo;
            $company_data['created_by'] = Auth::check() ? Auth::id() : Null;
        
            # add user data
            if($inserted_data = App\Models\User::create($user_data)) {
                $user_id = $inserted_data->id;
                # add company data
                $inserted_comp_data = Company::create($company_data);
                $company_id = $inserted_comp_data->id;
                
                # add company user data
                $cu_data['company_id'] = $company_id;
                $cu_data['user_id'] = $user_id;
                App\Models\CompanyUser::create($cu_data);
                
                # send details to superadmin
                $sadmins = App\Models\User::whereHas('user_role', function($query) {
                    $query->where('role_code', 'superadmin');
                })->pluck('email', 'id');
        
                foreach ($sadmins as $admin) {
                    Mail::send('emails.'.app()->getLocale().'.company_registered', compact('inserted_comp_data', 'inserted_data'), function($message) use ($admin) {
                        $message->to($admin)->subject(__('email.subject.company_registered'));
                    });
                }
        
                return redirect(app()->getLocale().'/cregistered');
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
        checkAuthorization(['superadmin']);
        $id = $request->segment(3);
        $company = Company::find($id);
        $page_title = trans_choice('menu.company', 1).': '.$company->name;
        return view('companies.show', compact('page_title', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        checkAuthorization(['superadmin']);
        $page_title = __('form.label.update').' '.trans_choice('menu.company', 1);
        $id = $request->segment(3);
        $company = Company::find($id);
        $countries = App\Models\Country::orderBy('name', 'asc')->pluck('name', 'id');
        $n_employees = App\Models\EmployeeNo::orderBy('created_at', 'asc')->pluck('nos', 'id');
        
        return view('companies.edit', compact('page_title', 'company', 'countries', 'n_employees'));
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
        $company = Company::find($id);
        $except = array('_token', '_method');
        $data = $request->except($except);
        if($request->file('logo')) {
            $fid = $company->logo ? $company->logo : null;
            $file = $request->file('logo');
            if($company->file) {
                $fid = $company->file->id;
                $file_key = $company->file->file_key;
                # delete existing file from bucket
                deleteFromBucket($file_key);
            }
            
            # upload new selected file
            $file_name = generateFileName($file->getClientOriginalName());
            $file_key = getRandomString(5).date('dmYHis').'.'.$file->extension();
            $mime_type = $file->getClientMimeType();
            uploadToBucket($file->getPathname(), $file_key);
            
            # update files table
            $fdata['file_name'] = $file_name;
            $fdata['file_key'] = $file_key;
            $fdata['mime_type'] = $mime_type;
            $inserted_fdata = App\Models\File::updateOrCreate(['id' => $fid], $fdata);
            $fid = $inserted_fdata->id;
            
            $data['logo'] = $fid;
        }
        
        if(Company::where('id', $id)->update($data)) {
            return redirect(app()->getLocale().'/companies')->with('success', trans_choice('menu.company', 1).' '.trans_choice('messages.updated', 1));
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
        $company = Company::find($id);
        
        # delete company users from users table 
        foreach($company->company_user as $cuser) {
            $cuser->user->delete();
        }
        if($company->delete()) {
            return redirect(app()->getLocale().'/companies')->with('success', trans_choice('menu.company', 1).' '.trans_choice('messages.deleted', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
    
    public function company_registered() {
        $page_title = __('messages.cregistered');
        return view('companies.company_registered', compact('page_title'));
    }
    
    public function supdate(Request $request) {
        $id = $request->segment(3);
        $status = $request->segment(4);
        $company = Company::find($id);
        $company->status = $status;
        if($company->save()) {
            # update user status
            if($company->company_user) {
                $password = getRandomString(8);
                $user_data['password'] = Hash::make($password);
                $user_data['status'] = $status;
                
                foreach($company->company_user as $cuser) {
                    App\Models\User::where('id', $cuser->user->id)->update($user_data);
                    
                    # if status inactive > active, send mail with temp password
                    if($status == 'active') {
                        $mail_data = ['email'=>$cuser->user->email, 'password'=>$password];
                        Mail::send('emails.'.app()->getLocale().'.user_activated', compact('mail_data'), function($message) use ($mail_data) {
                            $message->to($mail_data['email'])->subject(__('email.subject.user_activated'));
                        });
                    }
                }
            }
            return redirect()->back()->with('success', __('form.label.status').' '.trans_choice('messages.updated', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
}
