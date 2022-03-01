<?php

namespace App\Services;

use App\Repositories\BlogRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BlogService
{
    public function getBlogs(): Collection
    {
        $blogResult = DB::transaction(function () {
            $blogRepository = new BlogRepository();
            $blogs = $blogRepository->getByUserId();

            return $blogs;
        });

        return $blogResult;
    }


    public function createBlogs(
        Request $request
    ): void {
        try {
            DB::transaction(function () use($request) {
                $blogRepository = new BlogRepository();
                $categoryRepository = new CategoryRepository();
                $categoryCnt = $categoryRepository->cntCategory();

                $request->merge([
                    'user_id' => Auth::id(),
                    'category_id' => $categoryCnt ? 1 : $categoryCnt + 1
                ]);

                $blogRepository->registerBlog($request);
                $categoryRepository->registerCategory($request);
            });
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function selectByBlogId(int $blogId): Model
    {
        $blogResult = DB::transaction(function () use ($blogId) {
            $blogRepository = new BlogRepository();
            $blog = $blogRepository->selectByBlogId($blogId);

            return $blog;
        });

        return $blogResult;
    }

    public function updateBlog(
        Request $request,
        int $blogId
    ): void {
        try {
            DB::transaction(function () use($request, $blogId) {
                $blogRepository = new BlogRepository();
                $categoryRepository = new CategoryRepository();
                $blog = $blogRepository->selectByBlogId($blogId);

                $blogRepository->updateBlog($request, $blog);
                $categoryRepository->updateCategory($request, $blog);
            });
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function deleteBlog(
        Model $blog
    ): void {
        try {
            DB::transaction(function () use($blog) {
                $blogRepository = new BlogRepository();
                $blogRepository->deleteBlog($blog);
            });
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }
}
