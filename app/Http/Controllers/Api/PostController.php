<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::all();
        // return response($posts, 200);
        $msg = ['Data fetched successfully'];

        return response()->json($posts, 200, $msg);
    }
}
