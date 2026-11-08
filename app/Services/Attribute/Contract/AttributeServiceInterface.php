<?php

namespace App\Services\Attribute\Contract;

use Illuminate\Support\Collection;
use App\Models\Attribute;

interface AttributeServiceInterface
{
    public function ViewAttributes(): Collection;
    public function ViewAttribute(int $id): ?Attribute;
    public function CreateAttribute(array $data): Attribute;
    public function UpdateAttribute(int $id, array $data): ?Attribute;
    public function DeleteAttribute(int $id);
}
