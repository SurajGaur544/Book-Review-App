<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    // This method will show review in backend
    public function index(Request $request){
        $reviews = Review::with('book','user')->orderBy('created_at','DESC');
        
        if(!empty($request)){
            $reviews = $reviews->where('review','like','%'.$request->keyword.'%');
        }
        $reviews = $reviews->paginate(7);
        return view('account.reviews.list',[
            'reviews'=>$reviews
        ]);
    }

    // This method will show edit page
    public function edit($id){
        $reviews = Review::findOrFail($id);
        return view('account.reviews.edit',[
            'reviews' => $reviews
        ]);
    }

    // This method will update review in backend
    public function updateReview($id, Request $request){
        $reviews = Review::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'review' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('account.reviews.edit',$id)->withInput()->withErrors($validator);
        }

        $reviews->review = $request->review;
        $reviews->status = $request->status;
        $reviews->save();

        session()->flash('success','Review updated successfully.');

        return redirect()->route('account.reviews.list');
    }

    // This method will remove review in db
    public function destroy($id){
        $reviews = Review::findOrFail($id);
        $reviews->delete();

        session()->flash('success','Review Deleted successfully.');
        return redirect()->route('account.reviews.list');
    }

    public function myReview(Request $request){
        $reviews = Review::with('book')->where('user_id',Auth::user()->id);
        
        $reviews = $reviews->orderBy('created_at','DESC');
        if($request->keyword){
            $reviews = $reviews->where('review','like','%'.$request->keyword.'%');
        }
        $reviews = $reviews->paginate(7);
        
        return view('account.myReviews.myReview',['reviews'=> $reviews]);
    }

    public function delete($id){
        $reviews = Review::findOrFail($id);
        $reviews->delete();

        session()->flash('success','Review Deleted successfully.');
        return redirect()->route('account.myReviews.myReview');
    }

    public function update($id){
        $review = Review::where([
            'id' => $id,
            'user_id' => Auth::user()->id
        ])->first();
        return view('account.myReviews.edit',['reviews'=>$review]);
    }

    public function updateProcess($id, Request $request){
        $review = Review::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'review' => 'required',
            'rating' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->route('account.myReviews.edit',$id)->withInput()->withErrors($validator);
        }

        $review->review = $request->review;
        $review->rating = $request->rating;
        $res = $review->save();

        if($res){
        session()->flash('success','Review Updated successfully.');
        return redirect()->route('account.myReviews.myReview');
        }else{
            session()->flash('error','Review Updated failed.');
            return redirect()->route('account.myReviews.myReview');
        }
    }
}
