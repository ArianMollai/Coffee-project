<?php

namespace App\Services\Price;

use App\Repositories\Price\Contract\PriceRepositoryInterface;
use App\Models\Price;
use App\Services\Price\Contract\PriceServiceInterface;

class PriceService implements PriceServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private PriceRepositoryInterface $priceRepository)
    {}

    public function ViewPrice(int $id): ?Price
    {
        return $this->priceRepository->ViewPrice($id);
    }

    public function CreatePrice(array $data): Price
    {
        $data['final_price']=$data['price'] - ($data['price'] * $data['discount']/100);

        return $this->priceRepository->CreatePrice($data);
    }

    public function UpdatePrice(int $id, array $data): ?Price
    {
        $price=$this->ViewPrice($id);

        $data['final_price'] = $data['price'] - ($data['price'] * $data['discount']/100);

        return $this->priceRepository->UpdatePrice($price, $data);
    }

    public function DeletePrice(int $id)
    {
        $price=$this->ViewPrice($id) ?? throw new Exception("Price not found");
        
        return $this->priceRepository->DeletePrice($price);
    }

    public function SyncIngridients(Price $price, array $ingridients)
    {
        return $price->Ingridinets()->sync($ingridients);
    }
}
