<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryRepository
{

    public function registerCategory(
        Request $request
        ): void {
            Category::create([
                'category_name' => $request->category_name
            ]);
    }

    public function cntCategory(): int
    {
        return Category::query()->get()
                                ->count();
    }

    public function updateCategory(Request $request, Blog $blog): void
    {
        $blog->category->update([
            'category_name' => $request->category_name
        ]);
    }
}
