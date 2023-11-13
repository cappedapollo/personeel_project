<?php

namespace App\Http\Controllers;

use App;
use App\Models\UserImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\UserImportExcel;
use Mail;

class UserImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        checkAuthorization(['superadmin', 'admin']);
        $page_title = __('form.label.upload').' '.__('form.label.personeel');
        $role_code = Auth::user()->user_role->role_code;
        $user_id = ($role_code == 'superadmin') ? '' : Auth::id();
        
        $imports = UserImport::when($user_id, function ($query, $user_id) {
            $query->where('user_id', $user_id);
        })->orderBy('created_at', 'desc')->get();
        
        if ($request->isMethod('post')) {
            if($request->file('file')) {
                $file = $request->file('file');
                $file_name = $file->getClientOriginalName();
                
                # insert into user_imports table
                $udata['user_id'] = Auth::id();
                $udata['file_name'] = $file_name;
                $udata['total_users'] = 0;
                $inserted_udata = UserImport::create($udata);
                
                # import data
                $request['user_import_id'] = $inserted_udata->id;
                $import = new UserImportExcel;
                \Excel::import($import, $file);
                
                # update user count in user_imports table
                $uidata = UserImport::find($inserted_udata->id);
                $uidata->total_users = $import->getRowCount();
                $uidata->save();
                
                # send email to manager
                /* $managers = Auth::user()->users()->whereHas('user_role', function($query) {
                    $query->where('role_code', 'manager');
                })->get();
                foreach ($managers as $manager) {
                    $mail_data = ['email'=>$manager->email];
                    Mail::send('emails.'.app()->getLocale().'.user_imported', compact('mail_data'), function($message) use ($mail_data) {
                        $message->to($mail_data['email'])->subject(__('email.subject.user_imported'));
                    });
                } */
            }
        }
        return view('user_imports.index', compact('page_title', 'imports'));
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
        $uidata = UserImport::find($id);
        if($uidata->delete()) {
            return redirect(app()->getLocale().'/users/import')->with('success', __('form.label.file').' '.trans_choice('messages.deleted', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
}
