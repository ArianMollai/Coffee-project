<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    public const DISK="public";

    protected $guarded=['id'];
    protected $table="images";

    protected static function Booted(): void
    {
        static::deleted(function (Image $image){
            DB::afterCommit(fn () => Storage::disk(self::DISK)->delete($image->path));
        });
    }

    public function ImageAble(){
        return $this->morphTo();
    }
}
