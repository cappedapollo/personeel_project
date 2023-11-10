<?php

namespace App\Http\Controllers;

use App;
use App\Models\GoalReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalReviewController extends Controller
{
    public function show(Request $request)
    {
        checkAuthorization(['admin', 'manager']);
        $user_id = $request->segment(3);
        $user = App\Models\User::find($user_id);
        abort_if(!$user->manager, 401);
        
        $goal_reviews = GoalReview::where([['user_id', $user_id], ['type', 'radio']])->get();
        $page_title = trans_choice('menu.setting', 2).' - '.$user->full_name;
        if($user->function) {
            $page_title .= ' - '.$user->function;
        }
        
        $lang = (Auth::user()->company_user) ? Auth::user()->company_user->company->language : app()->getLocale();
        $categories = App\Models\Category::get();
        
        return view('goal_reviews.show', compact('page_title', 'goal_reviews', 'lang', 'user', 'categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            $r_avail = false;
            foreach ($request->review['title'] as $key=>$value) {
                if(!empty($value) || !empty($request->review['description'][$key])) {
                    $r_avail = true;
                    $id = $request->review['id'][$key];
                    $review_arr['user_id'] = $request->user_id;
                    $review_arr['added_by'] = Auth::id();
                    $review_arr['title'] = $value;
                    $review_arr['description'] = $request->review['description'][$key];
        
                    GoalReview::updateOrCreate(['id' => $id], $review_arr);
                }
            }
            /* if($r_avail) {
                # add paragraph field
                $review_desc['user_id'] = $request->user_id;
                $review_desc['added_by'] = Auth::id();
                $review_desc['title'] = 'description';
                $review_desc['type'] = 'textarea';
                
                GoalReview::firstOrCreate([
                    'user_id'=>$request->user_id, 'title'=>'description', 'type'=>'textarea'
                ], $review_desc);
            } */
        
            return redirect()->back()->with('success', trans_choice('menu.setting', 2).' '.trans_choice('messages.updated', 2));
        }else{
            return redirect()->back()->with('error', __('messages.processing_err'));
        }
        return redirect()->back()->with('success', trans_choice('form.label.review', 2).' '.trans_choice('messages.updated', 2));
    }
    
    public function destroy(Request $request)
    {
        $resonse = array('status' => 'success');
        $goal_review = GoalReview::find($request->id);
        $user_id = $goal_review->user_id;
    
        if($goal_review->delete()) {
            $goal_reviews = GoalReview::where([['user_id', $user_id], ['type', 'radio']])->get();
            if($goal_reviews->count() == 0) {
                # delete paragraph record
                $goal_review_desc = GoalReview::where([['user_id', $user_id], ['type', 'textarea']])->delete();
            }
            
            $resonse['status'] = 'success';
        }else{
            $resonse['status'] = 'error';
        }
        
        return $resonse;
    }
}
