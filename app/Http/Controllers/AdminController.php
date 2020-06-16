<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Auth;
use Validator;
use Storage;
use DB;
use App\Mail\SendAdmin;
use Mail;
use Excel;
use App\Exports\BlogsExport;

class AdminController extends Controller
{
    public function halamanawal(Request $request)
    {
        $search = $request->search;

        if ($search == null) {
            // $blogs = Blog::where('user_id', Auth::id())->orderBy('title', 'asc')->paginate(3);
            $blogs = Blog::leftJoin('users', 'users.id', 'blogs.user_id')
            ->leftJoin('blog_category', 'blog_category.id', 'blogs.category_id')
            ->select('blogs.*', 'users.name', 'blog_category.name as category')->where('user_id', Auth::id())->orderBy('title', 'asc')->paginate(3);
            // $blogs = DB::table('blogs')
            // ->leftJoin('users', 'users.id', 'blogs.user_id')
            // ->leftJoin('blog_category', 'blog_category.id', 'blogs.category_id')
            // ->select('blogs.*', 'users.name', 'blog_category.name as category')->where('user_id', Auth::id())->orderBy('title', 'asc')->paginate(3);
        } else {
            // $blogs = Blog::where('user_id', Auth::id())->where('title', 'like', '%'. $search . '%')->orderBy('title', 'asc')->paginate(3);
            $blogs = Blog::leftJoin('users', 'users.id', 'blogs.user_id')
            ->leftJoin('blog_category', 'blog_category.id', 'blogs.category_id')
            ->select('blogs.*', 'users.name', 'blog_category.name as category')->where('user_id', Auth::id())->where('title', 'like', '%'. $search . '%')->orderBy('title', 'asc')->paginate(3);
            // $blogs = DB::table('blogs')
            // ->leftJoin('users', 'users.id', 'blogs.user_id')
            // ->leftJoin('blog_category', 'blog_category.id', 'blogs.category_id')
            // ->select('blogs.*', 'users.name', 'blog_category.name as category')->where('user_id', Auth::id())->where('title', 'like', '%'. $search . '%')->orderBy('title', 'asc')->paginate(3);
        }

        return view('admin.index', compact('blogs', 'search'));
    }

    public function create() {
        $categories = DB::table('blog_category')->get();
        return view('admin.create', compact('categories'));
    }

    public function export() {
        return Excel::download(new BlogsExport, 'data-blog.xlsx');
    }

    public function edit($id) {
        $blog = Blog::find($id);
        $categories = DB::table('blog_category')->get();
        // $blog = DB::table('blogs')->where('id', $id)->first();
        // dd($blog);
        // $blog = Blog::where('id', $id)->first();
        return view('admin.edit', compact('blog', 'categories'));
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

        $thumbnail = null;
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image')->storeAs('thumbnail', 'gambar_dari_blog_' . time() . '.' . $request->file('image')->getClientOriginalExtension());
        }

        // Blog::create([
        //     'user_id' => Auth::id(),
        //     'title' => $request->title,
        //     'content' => $request->content,
        //     'image' => $request->image,
        // ]);

        DB::table('blogs')->insert([
            'user_id' => Auth::id(),
            'category_id' => $request->category,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $thumbnail,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // $blog = new Blog();
        // $blog->user_id = Auth::id();
        // $blog->title = $request->title;
        // $blog->content = $request->content;
        // $blog->image = $thumbnail;
        // $blog->save();

        // $users = DB::table('users')->where('role', 'admin')->get();
        // foreach($users as $user) {
        //     Mail::to($user->email)->send(new SendAdmin($request->title));
        // }

        notify()->success('Berhasil menambahkan blog baru');
        return redirect('/admin'); //->with('success', 'Berhasil menambahkan blog baru');
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

        // Blog::where('id', $id)->update([
        //     'user_id' => Auth::id(),
        //     'title' => $request->title,
        //     'content' => $request->content,
        //     'image' => $request->image,
        // ]);

        DB::table('blogs')->where('id', $id)->update([
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

        // notify()->success('Berhasil mengedit blog');
        smilify('success', 'Berhasil mengedit blog');
        return redirect('/admin');
    }

    public function delete($id) {
        $blog = Blog::where('id', $id)->first();
        if ($blog->image != null) {
            Storage::delete($blog->image);
        }
        DB::table('blogs')->where('id', $id)->delete();

        return redirect('/admin');
    }
}
