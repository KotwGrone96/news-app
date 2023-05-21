<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function showPost($id)
    {
        return view('post.index');
    }
}
