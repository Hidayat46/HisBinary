<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function registration(){
        return view('frontend.register');
    }

    public function processregister(Request $request){
        $validator = Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|email',
        'password'=>'required|min:5|same:confirm_password',
        'confirm_password'=>'required'
        ]);

        if ($validator->passes()){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =Hash::make($request->password);
            $user->save();

            session()->flash('success','You have registerd successfuly');
            return redirect()->route('user.login');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function login(){
        return view('frontend.login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
        'email'=>'required|email',
        'password'=>'required'
        ]);

        if($validator->passes()){
        if(Auth::attempt(['email'=>$request->email , 'password'=>$request->password])){
            return redirect()->route('user.dashboard');
        }else{
            return redirect()->route('user.login')->with('error','Either Email/password is incorrect');
        }
        }else{
            return redirect()->route('user.login')->withErrors($validator)->withInput([$request->only('email')]);
        }
        }

    public function dashboard(){
        $posts = Post::all();
        return view('frontend.dashboard', compact('posts'));
    }

    public function postStore(Request $request){
        $post = new Post();
        $post->user_id = Auth()->id();
        $post->question_text = $request->question_text;
        $post->save();
        return redirect()->route('user.dashboard');
    }

    public function commentStore(Request $request){
        $comment = new Comment();
        $comment->user_id = Auth()->id();
        $comment->post_id = $request->post_id;
        $comment->comment_text = $request->comment_text;
        $comment->save();
        return redirect()->route('user.dashboard');
    }
}
