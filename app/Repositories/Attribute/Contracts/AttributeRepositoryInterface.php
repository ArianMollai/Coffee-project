<?php

namespace App\Repositories\Attribute\Contracts;

use App\Models\Attribute;
use Illuminate\Support\Collection;

interface AttributeRepositoryInterface
{
    public function ViewAttributes(): Collection;
    public function ViewAttribute(int $id): ?Attribute;
    public function CreateAttribute(array $data): Attribute;
    public function UpdateAttribute(Attribute $attribute, array $data): ?Attribute;
    public function DeleteAttribute(Attribute $attribute);
}
