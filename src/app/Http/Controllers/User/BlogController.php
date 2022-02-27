<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BlogController extends Controller
{
    private const TARGET_USER = 'user';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Blog::query();
        $blogs = $query->where('user_id', Auth::id())->get();

        return Inertia::render('Blog/Index', ['blogs' => $blogs, 'target' => self::TARGET_USER]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Blog/Create', ['target' => self::TARGET_USER]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'content' => ['required'],
        ]);

        $request->merge(['user_id' => Auth::id()]);

        Blog::create($request->all());

        return redirect()->route(self::TARGET_USER . '.blog.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return Inertia::render('Blog/Edit', ['blog' => $blog, 'target' => self::TARGET_USER]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogRequest  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => ['required'],
            'content' => ['required']
        ]);

        $blog->update($request->all());
        return redirect()->route(self::TARGET_USER . '.blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route(self::TARGET_USER . '.blog.index');
    }
}
