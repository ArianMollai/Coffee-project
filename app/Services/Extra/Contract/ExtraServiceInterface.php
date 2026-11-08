<?php

namespace App\Services\Extra\Contract;

use Illuminate\Support\Collection;
use App\Models\Extra;

interface ExtraServiceInterface
{
    public function ViewExtras(): Collection;
    public function ViewExtra(int $extraId): ?Extra;
    public function CreateExtra(array $data): Extra;
    public function UpdateExtra(int $extraId, array $data): ?Extra;
    public function DeleteExtra(int $extraId);
}
