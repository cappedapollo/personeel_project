<?php

namespace App\Http\Controllers;

use App;
use App\Models\FormData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use PDF;
use Mail;

class FormDataController extends Controller
{
    public function show(Request $request)
    {
        checkAuthorization(['manager', 'admin']);
        /* $selected_user_id = $request->segment(3);
        $review_type_num = $request->segment(4); */
        $params = base64_decode($request->segment(3));
        $param_arr = explode('/', $params);
        $selected_user_id = $param_arr[0];
        $review_type_num = $param_arr[1];
        
        $form_data_btn = __('form.array.form_data_btn');
        $show_ratings = in_array($review_type_num, array('3')) ? true : false;
        
        $review_type = App\Models\ReviewType::firstWhere('number', $review_type_num);
        if (Auth::user()->company_user)
        {
            $company_id = Auth::user()->company_user->company_id;
            if ($review_type->company_review_type)
            {
                $company_review_type = $review_type->company_review_type->firstWhere([['company_id', $company_id], ['review_type_id', $review_type->id]]);
                if ( $company_review_type )
                {
                    $review_type['name'] = $company_review_type->name;
                }
            }
        }
        
        $user = App\Models\User::find($selected_user_id);
        $lang = (Auth::user()->company_user) ? Auth::user()->company_user->company->language : app()->getLocale();
        $role_code = Auth::user()->user_role->role_code;
        $form = $user->form->where('completed', 'no')->sortDesc()->first();
        $category_ids = $form_data = array();
        
        if($form) {
            $category_ids = unserialize($form->category_ids);
            if($form->form_data) {
                $form_data = $form->form_data->where('review_type_id', $review_type->id)->where('year', null)->sortDesc()->first();
            }
        }
        
        $page_title = $review_type->name.' - '.$user->full_name;
        if($user->function) {
            $page_title .= ' - '.$user->function;
        }
        
        $categories = App\Models\Category::whereIn('id', $category_ids)->get();
        
        return view('form_data.show', compact('page_title', 'categories', 'lang', 'form', 'form_data', 'user', 'review_type', 'review_type_num', 'show_ratings'));
    }
    
    public function store(Request $request)
    {
        $except = array('_token', 'ans', 'id', 'save', 'save_pdf', 'save_final', 'review_type_num');
        $ans_arr = $request->ans;
        $form_data = $request->except($except);
        $review_type_num = $request->review_type_num;
        $form_data['answers'] = serialize($ans_arr);
        $user_id = $request->user_id;
        $form_data_id = $request->id;
        $_review_type = company_review_type($review_type_num);
        
        if($request->filled('save_pdf') || $request->filled('save_final')) {
            $goal_arr = isset($ans_arr['goals']) ? $ans_arr['goals'] : array();
            unset($ans_arr['goals']);
            unset($ans_arr['general']);
            unset($ans_arr['name']);
            unset($ans_arr['function']);
            
            $scores = array();
            $total_scat = $total_ans_count = $total_score = $total_average = 0;
            foreach ($ans_arr as $scatid=>$ans) {
                $sum = array_sum($ans);
                if($sum>0) {
                    $ans_count = count(array_filter($ans));
                    $average = ($sum>0) ? number_format($sum/$ans_count, 1) : '';
                    $average_r = ($average) ? number_format(round($average), 0) : '';
                    $scores[$scatid]['total'] = $sum;
                    $scores[$scatid]['average'] = $average;
                    $scores[$scatid]['average_r'] = $average_r;
                    
                    # calculate total competencies
                    $total_scat += $sum;
                    $total_ans_count += $ans_count;
                }
            }
            
            if($total_scat>0) {
                $caverage = ($total_scat>0) ? number_format($total_scat/$total_ans_count, 1) : '';
                $caverage_r = ($caverage) ? number_format(round($caverage), 0) : '';
                $scores['competencies']['total'] = $total_scat;
                $scores['competencies']['average'] = $caverage;
                $scores['competencies']['average_r'] = $caverage_r;
            }
            
            $gsum = array_sum($goal_arr);
            if($gsum>0) {
                $gaverage = ($gsum>0) ? number_format($gsum/count(array_filter($goal_arr)), 1) : '';
                $scores['goals']['total'] = $gsum;
                $scores['goals']['average'] = $gaverage;
                $scores['goals']['average_r'] = ($gaverage) ? number_format(round($gaverage), 0) : '';
            }
            
            if(count($scores) > 0) {
                $total_score = isset($scores['competencies']) ? $scores['competencies']['average_r'] : 0;
                $total_score += isset($scores['goals']) ? $scores['goals']['average_r'] : 0;
                $total_average = number_format($total_score/2, 1);
                
                $form_data['scores'] = serialize($scores);
                $form_data['total_score'] = $total_score;
                $form_data['average'] = number_format(round($total_average), 0);
            }
        }
        
        if($fd_data = FormData::updateOrCreate(['id' => $form_data_id], $form_data)) {
            $type = 'performance';
            if(isset($form_data['total_score'])) {
                $type = ($form_data['total_score'] == 0) ? 'performance' : 'scoresheet';
            }
            
            if($request->filled('save_pdf') || $request->filled('save_final')) {
                $user = App\Models\User::find($user_id);
                $form = $user->form->where('completed', 'no')->sortDesc()->first();
                $lang = (Auth::user()->company_user) ? Auth::user()->company_user->company->language : app()->getLocale();
                #$category_ids = $form_data = array();
                $category_ids = array();
                if($form) {
                    $category_ids = unserialize($form->category_ids);
                    $sub_category_ids = unserialize($form->sub_category_ids);
                    #$form_data = $form->form_data->where('review_type_id', $request->review_type_id);
                }
                
                $categories = App\Models\Category::whereIn('id', $category_ids)->get();
                $sub_categories = App\Models\SubCategory::whereIn('id', $sub_category_ids)->get();
                
                $ur_field = 'role_'.$lang;
                $user_roles = App\Models\UserRole::orderBy($ur_field, 'asc')->get();
                
                if($request->filled('save_pdf')) {
                    $submit_btn = 'save_pdf';
                    #return redirect(route('users.pdf', ['user' => $user_id, 'locale'=>app()->getLocale(), 'type'=>$review_type_num]));
                    $form_data_btn = __('form.array.form_data_btn');
                
                    $review_type = $_review_type->name;
                    $action = 'Created scoresheet [employee_name], review type: [review_type]';
                    # add log
                    #App\Models\Log::create(['module_id'=>$user_id, 'action_by'=>Auth::id(), 'action'=>$action, 'module'=>'user']);
                    App\Models\Log::create(['module_id'=>$fd_data->id, 'action_by'=>Auth::id(), 'action'=>$action, 'module'=>'form_data']);
                
                    $file_name = strtolower(str_replace(' ', '_', $review_type)).'_interview_'.date('dmYHi').'.pdf';
                    $attachment_data = ['user'=>$user, 'categories'=>$categories, 'form_data'=>$fd_data, 'form'=>$form, 'lang'=>$lang, 'review_type_num'=>$review_type_num, 'sub_categories'=>$sub_categories, 'type'=>$type, 'user_roles'=>$user_roles, 'ur_field'=>$ur_field, 'review_type'=>$_review_type, 'submit_btn'=>$submit_btn];
                    $pdf = PDF::loadView('pdfs/en/performance_interview', $attachment_data);
                    return $pdf->download($file_name);
                }
                elseif($request->filled('save_final')) {
                    $submit_btn = 'save_final';
                    # upload file
                    #$upload_dir = config('filesystems.upload_dirs.attachment_dir');
                    $file_name = 'scoresheet_'.date('dmYHi').'.pdf';
                    $file_key = getAlphaNumKey(5).date('dmYHis').'.pdf';
                    $file = storage_path('app/public').'/'.$file_name;
                    $attachment_data = ['user'=>$user, 'categories'=>$categories, 'form_data'=>$fd_data, 'form'=>$form, 'lang'=>$lang, 'type'=>$type, 'sub_categories'=>$sub_categories, 'review_type_num'=>$review_type_num, 'user_roles'=>$user_roles, 'ur_field'=>$ur_field, 'review_type'=>$_review_type, 'submit_btn'=>$submit_btn];
                    $pdf = PDF::loadView('pdfs/en/performance_interview', $attachment_data);
                    $pdf->save($file);
                    $mime_type = Storage::disk('public')->mimeType($file_name);
                    uploadToBucket($file, $file_key);
                    Storage::disk('public')->delete($file_name);
                
                    # insert into files table
                    $fdata['file_name'] = $file_name;
                    $fdata['file_key'] = $file_key;
                    $fdata['mime_type'] = $mime_type;
                    $inserted_fdata = App\Models\File::create($fdata);
                
                    # insert into archives
                    $adata['created_by'] = Auth::id();
                    $adata['form_data_id'] = $fd_data->id;
                    $adata['file_id'] = $inserted_fdata->id;
                    $adata['user_id'] = $user_id;
                    $adata['status'] = 'employee';
                    $inserted_adata = App\Models\Archive::create($adata);
                
                    # add log
                    $action = '[user_name] finalized the [review_type] [year] of [employee_name]';
                    App\Models\Log::create(['module_id'=>$fd_data->id, 'action_by'=>Auth::id(), 'action'=>$action, 'module'=>'form_data']);
                    
                    # update form table if all 3 forms submitted
                    if($review_type_num=='3') {
                        App\Models\Form::updateOrCreate(['id' => $fd_data->form_id], array('completed'=>'yes'));
                        # add another form with saved categories and subcategories
                        $_form_data['created_by'] = Auth::id();
                        $_form_data['user_id'] = $user_id;
                        $_form_data['category_ids'] = $form->category_ids;
                        $_form_data['sub_category_ids'] = $form->sub_category_ids;
                        $_form_data['question_ids'] = $form->question_ids;
                        App\Models\Form::create($_form_data);
                    }
                    
                    # send email to employee with credentials to login
                    $review_type1 = App\Models\ReviewType::firstWhere('number', '1');
                    if($fd_data->user->performance_email_sent==0 && $fd_data->user->user_role->role_code=='employee' && $fd_data->review_type_id==$review_type1->id) {
                        $password = getRandomString(8);
                        # update user data
                        $fd_data->user->password = Hash::make($password);;
                        $fd_data->user->status = 'active';
                        $fd_data->user->performance_email_sent = 1;
                        $fd_data->user->save();
                        
                        $mail_data = ['email'=>$fd_data->user->email, 'password'=>$password];
                        Mail::send('emails.'.app()->getLocale().'.user_registered', compact('mail_data'), function($message) use ($mail_data) {
                            $message->to($mail_data['email'])->subject(__('email.subject.user_registered'));
                        });
                    }
                    
                    # send email to employee about final review
                    $mail_data = ['email'=>$fd_data->user->email, 'user'=>Auth::user()->full_name, 'review_type_num'=>$review_type_num];
                    Mail::send('emails.'.app()->getLocale().'.final_review', compact('mail_data'), function($message) use ($mail_data) {
                        $message->to($mail_data['email'])->subject(__('email.subject.final_review'));
                    });
                
                    return redirect(app()->getLocale().'/archives/'.$user_id)->with('success', __('form.label.pdf').' '.trans_choice('messages.saved', 2));
                }
            }
            
            return redirect()->back()->with('success', trans_choice('form.label.rating', 2).' '.trans_choice('messages.saved', 2));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
    
    public function get_data(Request $request)
    {
        $user = App\Models\User::find($request->user_id);
        $forms = $user->form->where('completed', 'yes')->sortDesc();
        $form_data = collect();
        $sub_category_ids = $series = array();
        $review_type = App\Models\ReviewType::firstWhere('number', 3);
        
        if($forms) {
            foreach ($forms as $form) {
                $sub_category_ids = array_merge($sub_category_ids, unserialize($form->sub_category_ids));
                if($form->form_data) {
                    $fdata = $form->form_data->where('review_type_id', $review_type->id);
                    $form_data = $form_data->merge($fdata);
                }
            }
        }
        
        $form_data = $form_data->groupBy('year');
        $sub_category_ids = array_unique($sub_category_ids);
        $sub_categories = App\Models\SubCategory::whereIn('id', $sub_category_ids)->get();
        
        foreach ($form_data as $year => $_form_data) {
            $scores = unserialize($_form_data[0]->scores);
            $series_data = array();
            foreach ($sub_categories as $sub_category) {
                $_score = 0;
                if (isset($scores[$sub_category->id])) {
                    $_score = $scores[$sub_category->id]['average_r'];
                }
                
                array_push($series_data, (int)$_score);
            }
            array_push($series, array('name'=>$year, 'data'=>$series_data));
        }
        
        $data['sub_category_ids'] = $sub_category_ids;
        $data['sub_categories'] = $sub_categories;
        $data['series'] = $series;
        
        return json_encode($data);
    }
}
