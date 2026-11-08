<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product\Contract\ProductServiceInterface;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdatedProductRequest;
use App\Policies\ProductPolicy;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct(private ProductServiceInterface $productService){}

    public function ViewProducts(){
        $this->authorize('viewAny', Product::class);

        return ProductResource::collection($this->productService->ViewProducts());
    }

    public function ViewProduct(int $productId){
        $this->authorize('view', Product::class);

        return new ProductResource($this->productService->ViewProduct($productId));
    }

    public function CreateProduct(CreateProductRequest $request){
        $this->authorize('create', Product::class);

        return new ProductResource($this->productService->CreateProduct($request->validated()));
    }

    public function UpdateProduct(int $productId, UpdatedProductRequest $request){
        $this->authorize('update', Product::class);

        return new ProductResource($this->productService->UpdateProduct($productId, $request->validated()));
    }

    public function DeleteProduct(int $product_id){
        $this->authorize('delete', Product::class);

        $this->productService->DeleteProduct($product_id);

        return respponse()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
