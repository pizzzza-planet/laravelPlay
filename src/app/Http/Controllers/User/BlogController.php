<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Blog\CreateRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Models\Blog;
use App\Services\BlogService;
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
        $blogService = new BlogService();
        $blogs = $blogService->getBlogs();

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
     * @param  \App\Http\Requests\Blog\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $blogService = new BlogService();
        $blogService->createBlogs($request);

        return redirect()->route(self::TARGET_USER . '.blog.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($blogId)
    {
        $blogService = new BlogService();
        $blog = $blogService->selectByBlogId($blogId);

        return Inertia::render('Blog/Edit', ['blog' => $blog, 'target' => self::TARGET_USER]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Blog\UpdateRequest  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $blogId)
    {
        $blogService = new BlogService();
        $blogService->updateBlog($request, $blogId);

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
        $blogService = new BlogService();
        $blogService->deleteBlog($blog);

        return redirect()->route(self::TARGET_USER . '.blog.index');
    }
}
