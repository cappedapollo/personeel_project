<?php

namespace App\Http\Controllers;

use App;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function show(Request $request)
    {
        #$fkey = urldecode($request->segment(3));
        $fkey = $request->segment(3);
        $file = File::firstWhere('file_key', $fkey);
        if($file && $file->file_key) {
            $document_url = getLinkFromBucket($file->file_key);
            $mime_type = $file->mime_type;
            $filename = $file->file;
            
            return \Response::make(file_get_contents($document_url), 200, [
                'Content-Type' => $mime_type,
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }else {
            return redirect(app()->getLocale().'/')->with('error', __('form.label.file').' '.trans_choice('messages.not_found', 1));
        }
    }
    
    /* public function destroy(File $file)
    {
        $resonse = array('status' => 'success');
        # delete file
        if($file->file_name) {
            $upload_dir = config('filesystems.dirs.'.$file->dir);
            $file_to_delete = $upload_dir.'/'.$file->file_name;
            if(Storage::disk('public')->exists($file_to_delete)) {
                Storage::disk('public')->delete($file_to_delete);
            }
        }
        
        if($file->delete()) {
            $resonse['status'] = 'success';
        }else{
            $resonse['status'] = 'error';
        }
    
        return $resonse;
    } */
}
