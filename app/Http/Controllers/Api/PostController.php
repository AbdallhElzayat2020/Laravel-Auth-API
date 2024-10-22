<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Posts;

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
        $post = new PostResource(Posts::find($id));

        if ($post) {

            return $this->apiResponse($post, 'success', 200);
        }
        return $this->apiResponse(null, 'No data found', 404);

    }
}
