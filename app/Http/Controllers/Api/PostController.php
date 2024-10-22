<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    use ApiResponseTrait;
    public function index()
    {
        // $posts = Posts::all();

        // $array = [
        //     'data' => $posts,
        //     'message' => 'success',
        //     'status' => 200,
        // ];

        // return response()->json($array);
        $posts = Posts::all();

        $posts = PostResource::collection($posts);

        return $this->apiResponse($posts, 'success', 200);
    }
    public function show($id)
    {
        $post = Posts::find($id);

        if ($post) {

            return $this->apiResponse(new PostResource(Posts::find($id)), 'success', 200);
        }
        return $this->apiResponse(null, ' Data Not  found', 404);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->apiResponse(null, $validate->errors(), 400);
        }
        $post = Posts::create([
            'title' => $request->title,
            'body' => $request->body
        ]);
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'Post created successfully', 201);
        }
        return $this->apiResponse(null, 'Failed to create Post', 400);
    }
}