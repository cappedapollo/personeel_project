<?php

namespace App\Http\Controllers;

use App;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        checkAuthorization(['admin', 'manager']);
        $page_title = trans_choice('menu.setting', 2);
        $lang = (Auth::user()->company_user) ? Auth::user()->company_user->company->language : app()->getLocale();
        $role_code = Auth::user()->user_role->role_code;
        $categories = Category::get();
        
        return view('categories.index', compact('page_title', 'categories', 'lang'));
    }
    
    /* public function store(Request $request)
    {
        $except = array('_token', 'cat', 'subcat', 'que', 'review');
        $form_data = $request->except($except);
        $form_data['created_by'] = Auth::id();
        $form_data['category_ids'] = serialize($request->cat);
        $form_data['sub_category_ids'] = serialize($request->subcat);
        $form_data['question_ids'] = serialize($request->que);
        # add/update category answers
        if($inserted_data = App\Models\Form::updateOrCreate(['id' => $request->id], $form_data)) {
            
            # add/update reviews
            foreach ($request->review['title'] as $key=>$value) {
                if(!empty($value) || !empty($request->review['description'][$key])) {
                    $id = $request->review['id'][$key];
                    $review_arr['user_id'] = $request->user_id;
                    $review_arr['added_by'] = Auth::id();
                    $review_arr['title'] = $value;
                    $review_arr['description'] = $request->review['description'][$key];
            
                    App\Models\GoalReview::updateOrCreate(['id' => $id], $review_arr);
                }
            }
            
            return redirect()->back()->with('success', trans_choice('menu.setting', 2).' '.trans_choice('messages.updated', 2));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
    } */
    
    /* public function store(Request $request)
    {
        App\Models\SubCategory::create($request->except(['_token', 'type']));
        #added by csv import direct to table
        #App\Models\Question::create($request->except(['_token']));
        return redirect()->back();
    } */
    
    public function pdf(Request $request)
    {
        checkAuthorization(['superadmin']);
        $company_id = $request->segment(3);
        $submit_btn = '';
        $categories = Category::get();
        $company = App\Models\Company::find($company_id);
        
        $file_name = 'company_competencies_'.date('dmYHi').'.pdf';
        $attachment_data = ['company'=>$company, 'categories'=>$categories, 'submit_btn'=>$submit_btn];
        $pdf = PDF::loadView('pdfs/en/company_competencies', $attachment_data);
        return $pdf->download($file_name);
    }
}
