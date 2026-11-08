<?php

namespace App\Repositories\Extra;

use Illuminate\Support\Collection;
use App\Models\Extra;
use App\Repositories\Extra\Contract\ExtraRepositoryInterface;

class ExtraRepository implements ExtraRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function ViewExtras(): Collection
    {
        return Extra::latest()->get();
    }

    public function ViewExtra(int $extraId): ?Extra
    {
        return Extra::findOrFail($extraId);
    }

    public function CreateExtra(array $data): Extra
    {
        return Extra::create($data);
    }

    public function UpdateExtra(Extra $extra, array $data): ?Extra
    {
        $extra->update($data);

        return $extra;
    }

    public function DeleteExtra(Extra $extra)
    {
        return $extra->delete();
    }

    public function SyncProducts(Extra $extra, array $productsIds){
        return $extra->Products()->sync($productsIds);
    }
}
