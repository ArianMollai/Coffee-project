<?php

namespace App\Trait;

use App\Models\Image;

trait HasImages
{
    public function Images(){
        return $this->morphMany(Image::class, 'imageable')->orderBy('sort_order');
    }

    protected static function bootHasImages(): void
    {
        static::deleting(function ($model){
            if(method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()){
                return;
            }

            $model->Images()->get()->each->delete();
        });

    }
}