<?php

namespace App\Repositories\Product\Contract;

use Illuminate\Support\Collection;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function ViewProducts(): Collection;
    public function ViewProduct(int $id): ?Product;
    public function CreateProduct(array $data): Product;
    public function UpdateProduct(Product $product, array $data): Product;
    public function DeleteProduct(Product $product);
}
