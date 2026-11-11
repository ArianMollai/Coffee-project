<?php

namespace App\Repositories\Category;

use Illuminate\Support\Collection;
use App\Models\Category;
use App\Repositories\Category\Contract\CategoryRepositoryInterface;


class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function Index(): Collection
    {
        return Category::with('Children')->whereNull('parent_id')->latest()->get();
    }

    public function ViewOne(int $id): ?Category
    {
        return Category::with('Children')->findOrFail($id);
    }

    public function Create(array $data): Category
    {
        return Category::create($data);
    }

    public function Update(Category $category, array $data)
    {
        return $category->update($data);
    }

    public function Delete(Category $category)
    {
        return $category->delete();
    }
}
