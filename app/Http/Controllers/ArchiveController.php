<?php

namespace App\Http\Controllers;

use App;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class ArchiveController extends Controller
{
    public function show(Request $request)
    {
        checkAuthorization(['admin', 'manager']);
        $user_id = $request->segment(3);
        $user = App\Models\User::find($user_id);
        $page_title = trans_choice('menu.archive', 1).' - '.$user->full_name;
        $page_title .= ($user->function) ? ' - '.$user->function : '';
        $archives = Archive::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        
        return view('archives.show', compact('page_title', 'archives'));
    }
    
    public function supdate(Request $request) {
        $id = $request->segment(3);
        $status = $request->segment(4);
        $date_on = $status.'_on';
        $archive = Archive::find($id);
        $archive->status = $status;
        $archive->$date_on = date('Y-m-d H:i:s');
        if($archive->save()) {
            # add log
            $action = '[action_by] approved [review_type] [year] of [employee_name]';
            App\Models\Log::create(['module_id'=>$id, 'action_by'=>Auth::id(), 'action'=>$action, 'module'=>'archive']);
            
            return redirect()->back()->with('success', __('form.label.status').' '.trans_choice('messages.updated', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
    
    public function destroy(Request $request)
    {
        $id = $request->segment(3);
        $archive = Archive::find($id);
        $action = '[action_by] deleted '.$archive->form_data->review_type->name.' '.$archive->form_data->year.' of [user_name]';
        $module_id = $archive->user_id; 
        
        if($archive->delete()) {
            # add log
            App\Models\Log::create(['module_id'=>$module_id, 'action_by'=>Auth::id(), 'action'=>$action, 'module'=>'user']);
            
            return redirect()->back()->with('success', trans_choice('menu.archive', 1).' '.trans_choice('messages.deleted', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->segment(3);
        $except = array('_token', '_method');
        $data = $request->except($except);
        if(Archive::where('id', $id)->update($data)) {
            $archive = Archive::find($id);
            
            # delete uploaded pdf file from bucket
            if($archive->file) {
                $file_key = $archive->file->file_key;
                if($file_key) {
                    deleteFromBucket($file_key);
                }
            }
            
            # upload updated pdf file
            $user = App\Models\User::find($archive->user_id);
            $form = $archive->form_data->form;
            $lang = (Auth::user()->company_user) ? Auth::user()->company_user->company->language : app()->getLocale();
            $fd_data = $archive->form_data;
            $review_type_num = $archive->form_data->review_type->number;
            $_review_type = company_review_type($review_type_num);
            $submit_btn = '';
            
            $ur_field = 'role_'.$lang;
            $user_roles = App\Models\UserRole::orderBy($ur_field, 'asc')->get();
            
            $type = ($fd_data->total_score == 0) ? 'performance' : 'scoresheet';
            $category_ids = $sub_category_ids = array();
            if($form) {
                $category_ids = unserialize($form->category_ids);
                $sub_category_ids = unserialize($form->sub_category_ids);
            }
            
            $categories = App\Models\Category::whereIn('id', $category_ids)->get();
            $sub_categories = App\Models\SubCategory::whereIn('id', $sub_category_ids)->get();
            
            $upload_dir = config('filesystems.upload_dirs.attachment_dir');
            $file_name = 'scoresheet_'.date('dmYHi').'.pdf';
            $file_key = getRandomString(5).date('dmYHis').'.pdf';
            $file = storage_path('app/public').'/'.$file_name;
            $attachment_data = ['user'=>$user, 'categories'=>$categories, 'form_data'=>$fd_data, 'form'=>$form, 'lang'=>$lang, 'type'=>$type, 'sub_categories'=>$sub_categories, 'review_type_num'=>$review_type_num, 'user_roles'=>$user_roles, 'ur_field'=>$ur_field, 'review_type'=>$_review_type, 'submit_btn'=>$submit_btn];
            $pdf = PDF::loadView('pdfs/en/performance_interview', $attachment_data);
            $pdf->save($file);
            $mime_type = Storage::disk('public')->mimeType($file_name);
            uploadToBucket($file, $file_key);
            Storage::disk('public')->delete($file_name);
            
            # update file data
            $fdata['file_name'] = $file_name;
            $fdata['file_key'] = $file_key;
            $fdata['mime_type'] = $mime_type;
            $inserted_fdata = App\Models\File::where('id', $archive->file_id)->update($fdata);
            
            return redirect()->back()->with('success', trans_choice('menu.archive', 1).' '.trans_choice('messages.updated', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
}
