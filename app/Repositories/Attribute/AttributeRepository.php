<?php

namespace App\Repositories\Attribute;

use App\Models\Attribute;
use Illuminate\Support\Collection;
use App\Repositories\Attribute\Contracts\AttributeRepositoryInterface;



class AttributeRepository implements AttributeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function ViewAttributes(): Collection
    {
        return Attribute::with('AttributeValues')->latest()->get();
    }

    public function ViewAttribute(int $id): ?Attribute
    {
        return Attribute::with('AttributeValues')->findOrFail($id);
    }

    public function CreateAttribute(array $data): Attribute
    {
        return Attribute::create([
            'name' => $data['name'],
            'is_color' => $data['is_color']
        ]);
    }

    public function UpdateAttribute(Attribute $attribute, array $data): ?Attribute
    {
        $attribute->update($data);

        return $attribute;
    }

    public function DeleteAttribute(Attribute $attribute)
    {
        return $attribute->delete();
    }
}
