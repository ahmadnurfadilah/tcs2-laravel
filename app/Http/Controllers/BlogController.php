<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index() {
        $blogs = DB::table('blogs')->orderBy('id', 'desc')->get();
        return view('blog.index', compact('blogs'));
    }

    public function show($id) {
        $blog = DB::table('blogs')->where('id', $id)->first();
        return view('blog.show', compact('blog'));
    }
}
