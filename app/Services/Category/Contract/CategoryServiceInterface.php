<?php

namespace App\Services\Category\Contract;

use Illuminate\Support\Collection;
use App\Models\Category;
use App\Models\Product;

interface CategoryServiceInterface
{
    public function Index(): Collection;
    public function ViewOne(int $id): ?Category;
    public function Create(array $data): Collection;
    public function Update(int $id, array $data): Collection;
    public function Delete(int $id);
    public function SyncProducts(Product $product, array $categories);
}
