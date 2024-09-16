<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;

class BookController extends Controller
{
    // this method will show books listing page
    public function index(Request $request){

        $books = Book::with('reviews','user')->orderBy('created_at','DESC');
        // dd($books);
        if(!empty($request->keyword)){
            $books->where('title','like','%'.$request->keyword.'%');
        }

        $books = $books->paginate(6);
        return view('books.list',['books'=>$books]);

    }

    // this method will show create book page
    public function create(){
        return view('books.create');
    }

    // this method will a store book in database page
    public function store(Request $request){
        $rules = [
            'title' => 'required | min:3',
            'author' => 'required | min:3',
            'status' => 'required'
        ];

        if(!empty($request->image)) {
            $rules['image'] = 'image';
        }


        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }

        //  Save book in db

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();

        
        if(!empty($request->image)){
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('/uploads/books'),$imageName);
            $book->image = $imageName;
            $book->save();

            // $manager = new ImageManager(Driver::class);
            // $img = $manager->read(public_path('/uploads/books'.$imageName));

            // $img->resize(990);
            // $img->save( public_path('/uploads/books/thumb'.$imageName ));

            // $path = $request->file('image')->store('public/uploads/books');
            // $pathArray = explode('/',$path);
            // $imgPath = $pathArray[1];
            
            // $book->image = $imgPath;
            // $book->save();
        }
        return redirect()->route('books.index')->with('success','Book added successfully.');
    }

    // this method will show edit book page
    public function edit($id){
        $book = Book::findOrFail($id);
        return view('books.edit',['book'=>$book]);
    }

    // this method will show update book page
    public function update($id, Request $request){

        $book = Book::findOrFail($id);

        $rules = [
            'title' => 'required | min:3',
            'author' => 'required | min:3',
            'status' => 'required'
        ];

        if(!empty($request->image)) {
            $rules['image'] = 'image';
        }


        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('books.edit',$book->id)->withInput()->withErrors($validator);
        }

        //  Update book in db

        
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();

        
        if(!empty($request->image)){
            // this will delete old book image from books directy
            File::delete(public_path('/uploads/books'.$book->image));

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('/uploads/books'),$imageName);
            $book->image = $imageName;
            $book->save();

            // Generate image thumbnail here
            // $manager = new ImageManager(Driver::class);
            // $img = $manager->read(public_path('/uploads/books'.$imageName));

            // $img->resize(990);
            // $img->save( public_path('/uploads/books/thumb'.$imageName ));

            // $path = $request->file('image')->store('public/uploads/books');
            // $pathArray = explode('/',$path);
            // $imgPath = $pathArray[1];
            
            // $book->image = $imgPath;
            // $book->save();
        }
        return redirect()->route('books.index')->with('success','Book updated successfully.');
    }

    // this method will destroy book from database
    public function destroy(Request $request){

        
        $book = Book::find($request->id);

        if($book == null) {
            return response()->json([
                'status' => false,
                'message' => 'Book not found'
            ]);
        } else {
            File::delete(public_path('/uploads/books/'.$book->image));
            $book->delete();
            return response()->json([
                'status' => true,
                'message' => 'Book Deleted successfully.'
            ]);
        }

    }
}
