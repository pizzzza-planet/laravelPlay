<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogRepository
{
    public function getByUserId(): Collection
    {
        return Blog::with('category')->where('user_id', Auth::id())
                                     ->get();
    }

    public function registerBlog(
        Request $request
        ): void {
            Blog::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
            ]);
    }

    public function selectByBlogId(int $blogId): Blog
    {
        return Blog::with('category')->where('id', $blogId)
                                     ->first();
    }

    public function updateBlog(Request $request, Blog $blog): void
    {
        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
    }

    public function deleteBlog(Blog $blog): void
    {
        $blog->delete();
    }
}
