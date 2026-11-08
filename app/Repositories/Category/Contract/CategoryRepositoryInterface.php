<?php

namespace App\Repositories\Category\Contract;

use Illuminate\Support\Collection;
use App\Models\Category;


interface CategoryRepositoryInterface
{
    public function Index(): Collection;
    public function ViewOne(int $id): ?Category;
    public function Create(array $data): Category;
    public function Update(Category $category, array $data);
    public function Delete(Category $category);
}
