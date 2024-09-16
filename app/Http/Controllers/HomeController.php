<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    // This method will show home page
    public function index(Request $request){
        $books = Book::orderBy('created_at','DESC');

        if(!empty($request->keyword)){
            $books->where('title','like','%'.$request->keyword.'%');
        }

        $books = $books->where('status',1)->paginate(8);
        return view('home',['books'=> $books]);
    }

    // This method will show detail page
    public function detail($id){
        $books = Book::with(['reviews.user','reviews'=>function($query){
            $query->where('status',1);
        }])->findOrFail($id);
        
        $relatedBooks = Book::where('status',1)->take(3)->where('id','!=',$id)->inRandomOrder()->get();
        
        return view('books.bookdetail',[
            'book'=>$books,
            'relatedBooks' => $relatedBooks
        ]);
    }

    // This method will save review in db
    public function saveReview(Request $request) {
        $validator = Validator::make($request->all(),[
            'review' => 'required|min:10',
            'rating' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>'false',
                'error'=> $validator->errors()
            ]);
        }

        // Apply condition here

        $countReview = Review::where('user_id',Auth::user()->id)->where('book_id',$request->book_id)->count();

        if ($countReview > 0){
            session()->flash('error','You have already submitted a Review');
            return response()->json([
                'status'=>'true',
            ]);
        }

        $review = new Review();
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->user_id = Auth::user()->id;
        $review->book_id = $request->book_id;
        $review->save();

        session()->flash('message','Review Submitted Successfully');
        return response()->json([
            'status'=>'true',
        ]);
    }
    
    public function about(){
        return view('about');
    }
}
