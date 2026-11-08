<?php

namespace App\Repositories\Product;

use Illuminate\Support\Collection;
use App\Models\Product;
use App\Repositories\Product\Contract\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function ViewProducts(): Collection
    {
        return Product::with([
            'Prices',
            'Prices.AttributeValues',
            'Prices.AttributeValues.Attribute'
        ])->latest()->get();
    }

    public function ViewProduct(int $id): ?Product
    {
        return Product::findOrFail($id);
    }

    public function CreateProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function UpdateProduct(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }

    public function DeleteProduct(Product $product){
        return $product->delete();
    }
}
