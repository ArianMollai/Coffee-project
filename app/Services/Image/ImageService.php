<?php

namespace App\Services\Image;

use App\Models\Image;
use App\Trait\HasImages;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Image\Contract\ImageRepositoryInterface;
use App\Services\Image\Contract\ImageServiceInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Exception;
use InvalidArgumentException;

use RuntimeException;

class ImageService implements ImageServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ImageRepositoryInterface $imageRepsoitory)
    {
    }

    public function AddMany(Model $owner, array $files, ?int $primaryImageIndex=null): Collection
    {
        $this->AssetSuppoertsImages($owner);

        if(empty($files)){
            return collect();
        }

        $folder=Str::plural(Str::snake(class_basename($owner))) . '/' . $owner->getKey();

        $order=$this->imageRepsoitory->NextSortOrder($owner);

        $stored=[];
        $created=collect();

        try{
            foreach($files as $index => $file){
                $path=$file->store($folder, Image::DISK);
                $stored[]=$path;

                $created->push($this->imageRepsoitory->Create($owner, [
                    'path' => $path,
                    'sort_order' => $order++,
                    'is_primary' => $index===$primaryImageIndex
                ]));
            }

        }catch(Throwable $e){
            Storage::disk(Image::DISK)->delete($stored);

            Throw $e;
        }

        return $created;
    }

    public function DeleteMany(Model $owner, array $imageIds): void
    {
        $this->AssetSuppoertsImages($owner);

        if(empty($imageIds)){
            return;
        }

        $imageIds = array_unique($imageIds);

        $images=$owner->images()->whereIn('id', $imageIds)->get();

        if($images->count() !== count(array_unique($imageIds))){
            throw new Exception("One of the prices dosent belong to this product");
        }

        $images->each(fn(Image $image) => $this->imageRepsoitory->Delete($image));
    }

    private function AssetSuppoertsImages(Model $owner){
        if(! in_array(HasImages::class, class_uses_recursive($owner))){
            throw new Exception("This asset dosent support image");   
        }
    }

    public function SetPrimary(Model $owner, int $imageId): Image
    {
        $this->AssetSuppoertsImages($owner);

        return DB::transaction(function () use ($owner, $imageId){
            $image=$this->imageRepsoitory->FindImageByOwner($owner, $imageId);

            $this->imageRepsoitory->UpdateMany($owner, ['is_primary' => false]);

            $this->imageRepsoitory->UpdateById($image, ['is_primary' => true]);

            return $image->refresh();

        });
    }
}
