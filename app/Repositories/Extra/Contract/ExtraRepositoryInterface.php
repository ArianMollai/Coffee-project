<?php

namespace App\Repositories\Extra\Contract;

use Illuminate\Support\Collection;
use App\Models\Extra;

interface ExtraRepositoryInterface
{
    public function ViewExtras(): Collection;
    public function ViewExtra(int $extraId): ?Extra;
    public function CreateExtra(array $data): Extra;
    public function UpdateExtra(Extra $extra, array $data): ?Extra;
    public function DeleteExtra(Extra $extra);
    public function SyncProducts(Extra $extra, array $productsIds);
}
