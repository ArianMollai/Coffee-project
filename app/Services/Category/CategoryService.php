<?php

namespace App\Services\Category;

use Illuminate\Support\Collection;
use App\Repositories\Category\Contract\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Category\Contract\CategoryServiceInterface;
use App\Models\Product;

class CategoryService implements CategoryServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {}

    public function Index(): Collection
    {
        return $this->categoryRepository->Index();
    }

    public function ViewOne(int $id): ?Category
    {
        return $this->categoryRepository->ViewOne($id) ?? throw new ModelNotFoundException('Category not found');
    }

    public function Create(array $data): Collection
    {
        $this->categoryRepository->Create($data) ?? throw new Exception('Couldnt create category');
        

        return $this->categoryRepository->Index();
    }

    public function Update(int $id, array $data): Collection
    {
        $category=$this->ViewOne($id) ?? throw new ModelNotFoundException('Category not found');

        $this->categoryRepository->Update($category, $data) ?? throw new Exception('Couldnt update category');

        return $this->Index();
    }

    public function Delete(int $id): Collection
    {
        $category=$this->ViewOne($id) ?? throw new ModelNotFoundException('Category not found');

        $this->categoryRepository->Delete($category) ?? throw new Exception('Couldnt delete category');

        return $this->Index();
    }

    public function SyncProducts(Product $product, array $categories){
        return $product->Categories()->sync($categories);
    }
}
