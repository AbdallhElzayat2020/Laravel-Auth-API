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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ], [
            'title.required' => 'العنوان مطلوب',
            'title.string' => 'العنوان يجب أن يكون نصًا',
            'title.max' => 'العنوان يجب ألا يتجاوز 255 حرفًا',
            'body.required' => 'المحتوى مطلوب',
            'body.string' => 'المحتوى يجب أن يكون نصًا',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $post = Posts::create($validator->validated());
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'تم إنشاء المنشور بنجاح', 201);
        }
        return $this->apiResponse(null, 'فشل في إنشاء المنشور', 400);
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'body' => 'string',
        ], [
            'title.required' => 'العنوان مطلوب',
            'title.string' => 'العنوان يجب أن يكون نصًا',
            'title.max' => 'العنوان يجب ألا يتجاوز 255 حرفًا',
            'body.required' => 'المحتوى مطلوب',
            'body.string' => 'المحتوى يجب أن يكون نصًا',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $post = Posts::find($id);
        if (!$post) {
            return $this->apiResponse(null, 'المنشور غير موجود', 404);
        }
        $post->update($validator->validated());

        return $this->apiResponse(new PostResource($post), 'تم تحديث المنشور بنجاح', 200);
    }

    public function destory($id)
    {
        $post = Posts::find($id);
        if (!$post) {
            return $this->apiResponse(null, 'المنشور غير موجود', 404);
        }
        $post->delete($id);
        return $this->apiResponse(null, 'تم حذف المنشور بنجاح', 200);
    }
}