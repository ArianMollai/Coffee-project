<?php

namespace App\Repositories\Image\Contract;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

interface ImageRepositoryInterface
{
    public function Create(Model $owner, array $data): Image;
    public function Delete(Image $image);
    public function NextSortOrder(Model $owner): int;
    public function UpdateById(Image $image, array $data): ?Image;
    public function FindImageByOwner(Model $owner, int $imageId): ?Image;
    public function UpdateMany(Model $model, array $data): Model;
}
