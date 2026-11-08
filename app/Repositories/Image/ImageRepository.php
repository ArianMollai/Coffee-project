<?php

namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\Image\Contract\ImageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ImageRepository implements ImageRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function Create(Model $owner, array $data): Image
    {
        return $owner->Images()->create($data);
    }

    public function Delete(Image $image){
        return $image->delete();
    }

    public function UpdateById(Image $image, array $data): ?Image
    {
        $image->update($data);

        return $image;
    }

    public function NextSortOrder(Model $owner): int
    {
        $maxOrder=(int) $owner->Images()->max('sort_order');

        return $maxOrder===null ? 0:$maxOrder+1;
    }

    public function FindImageByOwner(Model $owner, int $imageId): ?Image
    {
        return $owner->Images()->whereKey($imageId)->firstOrFail();
    }

    public function UpdateMany(Model $owner, array $data): Model
    {
        $owner->Images()->update($data);

        return $owner;
    }
}
