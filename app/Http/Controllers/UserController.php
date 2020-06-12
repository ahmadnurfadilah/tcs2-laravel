<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $nama = 'Putri';
        return view('profile', compact('nama'));
        // return view('profile', [
        //     'user' => $nama
        // ]);
    }

    public function show($userId, Request $get) {
        return view('profile-user', compact('userId'));
    }
}
