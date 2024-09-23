<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;

use function Laravel\Prompts\password;

class AccountController extends Controller
{
    // this method will show register page
    public function register(){
        return view('account.register');
    }

    // this method will register a user
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')->with('success','you are registerd successfully');
    }

    public function login(){
        return view('account.login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }

        if(Auth::attempt(['email'=> $request->email, 'password'=> $request->password])){
            return redirect()->route('account.profile');
        }else{
            return redirect()->route('account.login')->with('error','Either email and password incorect');
        }
    }

    // This method will show user profile page
    public function profile(){

        $user = User::find(Auth::user()->id);
        // dd($user);
        return view('account.profile',[
            'user' => $user
        ]);
    }

    // This method will update user profile
    public function updateprofile(Request $request){

        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id.',id',
        ];

        if(!empty($request->image)){
            $rules['image'] = 'image';
        }


        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // here we will upload image
        if(empty($request->image)){

            File::delete(public_path('storage/'.$user->image));

            // $image = $request->image;
            // $ext = $image->getClientOriginalExtension();
            // $imageName = time().".".$ext;
            // $image->move(public_path('uploads/profile'),$imageName);
            // $user->image = $imageName;
            // $res = $user->save();

            $path = $request->file('file')->store('public');
            $pathArray = explode('/',$path);
            $imgPath = $pathArray[1];
            
            $user->image = $imgPath;
            $res = $user->save();

            // $manager = new ImageManager(Driver::class);
            //  $img = $manager->read(public_path('public'.$imgPath));

            //  $img->cover(150, 150);
            //  $img->save ( public_path('public/thumb'.$imgPath ));

            if($res){
                return redirect()->route('account.profile')->with('success','Profile Updated successfully');
            }else{
               return redirect()->route('account.profile')->with('success','Profile Updated failed');
            }

        }else{
            return redirect()->route('account.profile')->with('success','Image field is not empty');
        }

    }
    public function changePassword(){
        $user = User::find(Auth::user()->id);
        return view('account.reviews.changePassPage',[
            'user' => $user
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updatepassword(Request $request){
        $request->validate([
            'oldpass'=>'required|min:6|max:30',
            'newpass'=>'required|min:6|max:30',
            'conpass'=>'required|min:6|max:30'
        ]);
        $current_user = auth()->user();

        if(Hash::check($request->oldpass, $current_user->password)){
            if($request->newpass == $request->conpass){
                $current_user->update([
                    'password'=>bcrypt($request->newpass)
                ]);
                return redirect()->back()->with('success','password successfully updated');
            }else{
                return redirect()->back()->with('error','Conform password does not matched');
            }
        }else{
            return redirect()->back()->with('error','old password does not matched');
        }

        return "<h1>here process update password</h1>";
    }

    public function about(){
        return view('account.about');
    }
}
