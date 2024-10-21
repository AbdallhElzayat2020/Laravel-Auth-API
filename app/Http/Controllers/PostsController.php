<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Posts::get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);
        try {

            Posts::create([
                'title' => $request->title,
                'body' => $request->body,
            ]);

            return redirect()->route('posts.index')->with('success', 'Post created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Posts::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // return $request;
        // التحقق من صحة البيانات
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        try {
            $post = Posts::findOrFail($id);

            // تحديث الـ post مباشرة باستخدام الكائن الممرر في الـ route
            $post->update([
                'title' => $request->title,
                'body' => $request->body,
            ]);

            return redirect()->route('posts.index')->with('success', 'Post updated successfully');
        } catch (\Throwable $th) {
            // التعامل مع أي خطأ غير متوقع
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Posts::findOrFail($id);
            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully');

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
