<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Blog\CreateRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Throwable;

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
        $blogs = $query->with('category')->where('user_id', Auth::id())->get();

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
        $categoryCnt = Category::query()->get()->count();

        $request->merge([
            'user_id' => Auth::id(),
            'category_id' => $categoryCnt ? 1 : $categoryCnt + 1
        ]);

        try {
            DB::transaction(function () use($request) {
                Blog::create([
                    'user_id' => $request->user_id,
                    'title' => $request->title,
                    'content' => $request->content,
                    'category_id' => $request->category_id,
                ]);

                Category::create([
                    'category_name' => $request->category_name
                ]);
            });
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }

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
        $query = Blog::query();
        $blog = $query->with('category')->where('id', $blogId)->first();

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
        $target = Blog::with('category')->where('id', $blogId)->first();

        try {
            DB::transaction(function () use($request, $target) {
                $target->update([
                    'title' => $request->title,
                    'content' => $request->content,
                ]);

                $target->category->update([
                    'category_name' => $request->category_name
                ]);
            });
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }

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
