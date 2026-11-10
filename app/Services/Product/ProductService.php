<?php

namespace App\Services\Product;

use App\Repositories\Product\Contract\ProductRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Product\Contract\ProductServiceInterface;
use App\Services\Price\Contract\PriceServiceInterface;
use App\Services\Category\Contract\CategoryServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Services\Image\Contract\ImageServiceInterface;
use Throwable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use InvalidArgumentException;


class ProductService implements ProductServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private PriceServiceInterface $priceService,
        private CategoryServiceInterface $categoryService,
        private ImageServiceInterface $imageService
    ){}
        
    public function ViewProducts(): Collection
    {
        return $this->productRepository->ViewProducts();
    }

    public function ViewProduct(int $id): ?Product
    {
        return $this->productRepository->ViewProduct($id) ?? throw new ModelNotFoundException("Product not found");
    }

    public function CreateProduct(array $data): Product
    {
        $storedPaths=[];

        try{
            return DB::transaction(function () use ($data, &$storedPaths){
                $product=$this->productRepository->CreateProduct($data) ?? throw new Exception("Couldnt create product");

                $this->categoryService->SyncProducts($product, $data['categories']);

                foreach($data['prices'] as $price){
                    $newPrice=$this->priceService->CreatePrice([
                        'product_id' => $product['id'],
                        'price' => $price['price'],
                        'discount' => $price['discount'],
                        'inventory' => $price['inventory']
                    ]) ?? throw new Exception("Couldnt create price please try again later");
                

                    $newPrice->AttributeValues()->sync($price['attribute_value_ids']);

                    $ingridients=[];

                    foreach($price['ingridients'] as $ingridient){
                        $ingridients[$ingridient['ingridient_id']]=[
                        'unit_id' => $ingridient['unit_id'],
                        'volume' => $ingridient['volume']
                        ];
                    }

                    $this->priceService->SyncIngridients($newPrice, $ingridients);
                }

                if(! empty($data['images'])){
                    $images=$this->imageService->AddMany($product, $data['images'], $data['primary_image_index']);
                    $storedPaths=$images->pluck('path')->all();
                }

                $product->load(['Categories', 'Prices.Ingridinets', 'Prices.AttributeValues.Attribute', 'Images']);

                $pivots=$product->Prices->flatMap->Ingridinets->pluck('pivot');
                (new \Illuminate\Database\Eloquent\Collection($pivots))->load('Unit');

                return $product;

            });
        }catch(Throwable $e){
            Storage::disk(Image::DISK)->delete($storedPaths);
            throw $e;
        }

    }

    public function UpdateProduct(int $id, array $data): ?Product
    {
        return DB::transaction(function () use ($id, $data){
            $product=$this->productRepository->ViewProduct($id) ?? throw new ModelNotFoundException("Product not found");

            $this->productRepository->UpdateProduct($product, Arr::only($data, ['name', 'description'])) ?? throw new Exception("Couldnt update product");

            if(isset($data['categories'])){
                $this->categoryService->SyncProducts($product, $data['categories']);
            }   

            if(isset($data['prices'])){
                $existings=$product->Prices->keyBy('id');
                $keepIds=[];

                foreach($data['prices'] as $priceData){
                    if(!empty($priceData['id'])){
                        $price=$existings->get($priceData['id']) ?? throw new Exception("This price dosent belongs to this product");
                    
                        $this->priceService->UpdatePrice($priceData['id'], $priceData) ?? throw new Exception("Couldnt update price tr again later");

                        $keepIds[]=$price->id;

                        $price->AttributeValues()->sync($priceData['attribute_value_ids']);

                        $ingridients=[];
 
                        foreach($priceData['ingridients'] as $ingridientData){
                            $ingridient[$ingridientData['ingridient_id']]=[
                                'unit_id' => $ingridient['unit_id'],
                                'volume' => $ingridient['volume']
                            ];
                        }

                        $this->priceService->SyncIngridients($price, $ingridients);

                    }else{
                        $newPrice=$this->priceService->CreatePrice([
                            'product_id' => $product->id,
                            'price' => $priceData['price'],
                            'discount' => $priceData['discount'],
                            'inventory' => $priceData['inventory']
                        ]);

                        $keepIds[]=$newPrice->id;

                        $newPrice->AttributeValues()->sync($priceData['attribute_value_ids'] ?? []);

                        $ingridients=[];

                        foreach($priceData['ingridients'] as $ingridientData){
                            $ingridients[$ingridientData['ingridient_id']]=[
                                'unit_id' => $ingridientData['unit_id'],
                                'volume' => $ingridientData['volume']
                            ];
                        }

                        $this->priceService->SyncIngridients($newPrice, $ingridients);
                    }
                }

                foreach($existings->keys()->diff($keepIds) as $deletePriceId){
                    $this->priceService->DeletePrice($deletePriceId);
                }
            }

            $deleteImageIds=$data['delete_image_ids'] ?? [];

            $primaryImageId= $data['primary_image_id'] ?? null;
            $primaryImageIndex = $data['primary_image_index'] ?? null;

            if( $primaryImageId !==null && $primaryImageIndex !== null){
                throw new InvalidArgumentException('You can only select one primary image.');
            }

            if($primaryImageId !== null && in_array($primaryImageId, $deleteImageIds)){
                throw new InvalidArgumentException('You cannot set a deleted image as primary.');
            }

            if(!empty($deleteImageIds)){
                $this->imageService->deleteMany($product, $deleteImageIds);
            }

            $newImages= collect();

            if(!empty($data['images'])){
                $newImages=$this->imageService->AddMany($product, $data['images'], null);
            }

            if($primaryImageId !== null){
                $this->imageService->SetPrimary($product, $primaryImageId);
            }

            if($primaryImageIndex !== null){
                $selectedImage=$newImages->get($primaryImageIndex) ?? throw new InvalidArgumentException('Invalid primary image index.');

                $this->imageService->SetPrimary($product, $selectedImage->id);
            }

            /* if(! empty($data['images'])){
                $this->imageService->DeleteMany($product, $data['delete_image_ids']);
            }

            if(! empty($data['images'])){
                $this->imageService->AddMany($product, $data['images'], $data['primary_image_index'] ?? null);

                if(in_array($data['primary_image_index'], $data['delete_image_ids'])){
                    throw new InvalidArgumentException("You cannot set a deleted image as primary.");
                }

                $this->imageService->SetPrimary($product, $data['primary_image_index']);
            } */

            $product->load(['Categories', 'Prices.Ingridinets', 'Prices.AttributeValues.Attribute']);

            $pivots=$product->Prices->flatMap->Ingridinets->pluck('pivot');
            (new \Illuminate\Database\Eloquent\Collection($pivots))->load('Unit');

            return $product;
        });
    }

    public function DeleteProduct(int $id){
        $product=$this->productRepository->ViewProduct($id) ?? throw new ModelNotFoundException("Product not found");

        return $this->productRepository->DeleteProduct($product);
    }
}
