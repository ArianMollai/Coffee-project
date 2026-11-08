<?php

namespace App\Services\Image\Contract;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface ImageServiceInterface
{
    public function AddMany(Model $owner, array $files): Collection;
    public function DeleteMany(Model $owner, array $imageIds): void;
}
