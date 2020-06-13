<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use Auth;
use Validator;

class AdminController extends Controller
{
    public function halamanawal()
    {
        $blogs = Blog::get();
        dd($blogs);

        // $user = Auth::user();
        // dd($user->id);

        return 'hi admin';
    }

    public function create() {
        return view('admin.create');
    }

    public function store(Request $request) {
        $messages = [
            'required' => 'Input :attribute wajib diisi.',
            'min' => 'Input :attribute minimal :min karakter.',
        ];

        Validator::make($request->all(), [
            'title' => 'required|min:4',
            'content' => 'required',
        ], $messages)->validate();

        Blog::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
        ]);

        return redirect('/admin');
    }
}
