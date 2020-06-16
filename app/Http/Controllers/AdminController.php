<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Auth;
use Validator;
use Storage;

class AdminController extends Controller
{
    public function halamanawal(Request $request)
    {
        $search = $request->search;

        if ($search == null) {
            $blogs = Blog::where('user_id', Auth::id())->orderBy('title', 'asc')->paginate(3);
        } else {
            $blogs = Blog::where('user_id', Auth::id())->where('title', 'like', '%'. $search . '%')->orderBy('title', 'asc')->paginate(3);
        }
        
        return view('admin.index', compact('blogs', 'search'));
    }

    public function create() {
        return view('admin.create');
    }

    public function edit($id) {
        $blog = Blog::find($id);
        // $blog = Blog::where('id', $id)->first();
        return view('admin.edit', compact('blog'));
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

        // Blog::create([
        //     'user_id' => Auth::id(),
        //     'title' => $request->title,
        //     'content' => $request->content,
        //     'image' => $request->image,
        // ]);

        $thumbnail = null;
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image')->storeAs('thumbnail', 'gambar_dari_blog_' . time() . '.' . $request->file('image')->getClientOriginalExtension());
        }

        $blog = new Blog();
        $blog->user_id = Auth::id();
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->image = $thumbnail;
        $blog->save();

        return redirect('/admin');
    }

    public function update($id, Request $request) {
        $messages = [
            'required' => 'Input :attribute wajib diisi.',
            'min' => 'Input :attribute minimal :min karakter.',
        ];

        Validator::make($request->all(), [
            'title' => 'required|min:4',
            'content' => 'required',
        ], $messages)->validate();

        Blog::where('id', $id)->update([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
        ]);

        // $blog = Blog::where('id', $id)->first();
        // $blog->user_id = Auth::id();
        // $blog->title = $request->title;
        // $blog->content = $request->content;
        // $blog->image = $request->image;
        // $blog->save();

        return redirect('/admin');
    }

    public function delete($id) {
        $blog = Blog::where('id', $id)->first();
        if ($blog->image != null) {
            Storage::delete($blog->image);
        }
        $blog->delete();

        return redirect('/admin');
    }
}
