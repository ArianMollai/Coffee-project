<?php

namespace App\Services\Product\Contract;

use Illuminate\Support\Collection;
use App\Models\Product;

interface ProductServiceInterface
{
    public function ViewProducts(): Collection;
    public function ViewProduct(int $id): ?Product;
    public function CreateProduct(array $data): Product;
    public function UpdateProduct(int $id, array $data): ?Product;
    public function DeleteProduct(int $id);
}