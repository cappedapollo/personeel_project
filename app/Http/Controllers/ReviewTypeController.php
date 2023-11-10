<?php

namespace App\Http\Controllers;

use App;
use App\Models\ReviewType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewTypeController extends Controller
{
    public function index()
    {
        checkAuthorization(['admin']);
        $page_title = trans_choice('menu.review_type', 2);
        $company_id = Auth::user()->company_user->company_id;
        $review_types = ReviewType::orderBy('number', 'asc')->get();
        foreach ($review_types as $review_type)
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
        return view('review_types.index', compact('page_title', 'review_types'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $except = array('_token', 'id');
        $rt_data = $request->except($except);
        $id = $request->id;
        $company_id = Auth::user()->company_user->company_id;
        $rt_data['review_type_id'] = $id;
        $rt_data['company_id'] = $company_id;
        
        #$saved_data = ReviewType::updateOrCreate(['id' => $id], $rt_data);
        #$saved_data = ReviewType::where('id', $id)->update($rt_data);
        $saved_data = App\Models\CompanyReviewType::updateOrCreate(['company_id'=>$company_id, 'review_type_id'=>$id], $rt_data);
        
        if($saved_data) {
            return redirect(app()->getLocale().'/review_types')->with('success', trans_choice('menu.review_type', 1).' '.trans_choice('messages.saved', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
    
    public function destroy(Request $request)
    {
        $id = $request->segment(3);
        $review_type = ReviewType::find($id);
        if($review_type->delete()) {
            return redirect()->back()->with('success', trans_choice('menu.review_type', 1).' '.trans_choice('messages.deleted', 1));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    }
}
