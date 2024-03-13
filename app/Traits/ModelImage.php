<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ModelImage
{
    /**
     * Boot the model image trait for a model.
     *
     * @return void
     */
    public static function bootModelImage(): void
    {
        static::deleting(function ($model) {
            $model->deleteImage();
        });
    }

    /**
     * Get the name of the "image_path" column.
     *
     * @return string
     */
    public function getImagePathColumn(): string
    {
        return defined(static::class . '::IMAGE_PATH') ? static::IMAGE_PATH : 'image_path';
    }

    /**
     * Initialize the model image trait for an instance.
     *
     * @return void
     */
    public function initializeModelImage(): void
    {
        $this->mergeFillable(['image']);
    }

    /**
     * @return string|null
     */
    public function getImageAttribute(): ?string
    {
        if ($imagePath = $this->{$this->getImagePathColumn()}) {
            return filter_var($imagePath, FILTER_VALIDATE_URL) ?: Storage::url($imagePath);
        }

        return null;
    }

    /**
     * @return void
     */
    public function deleteImage(): void
    {
        $imagePath = $this->{$this->getImagePathColumn()};

        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->deleteDirectory(dirname($imagePath));
        }
    }

    /**
     * @param \Illuminate\Http\UploadedFile|string|null $image
     * @return void
     */
    public function setImageAttribute(null|\Illuminate\Http\UploadedFile|string $image): void
    {
        $this->deleteImage();

        /**
         * If this is an uploaded image file, save it to local storage and get path for it
         * Otherwise store as a raw URL
         */
        if ($image instanceof \Illuminate\Http\UploadedFile) {
            $rootFolder = class_basename(self::class);
            $imagePath  = $image->store("{$rootFolder}/" . Str::random(), 'public');
        } elseif (! $imagePath = filter_var($image, FILTER_VALIDATE_URL)) {
            $imagePath = null;
        }

        $this->{$this->getImagePathColumn()} = $imagePath;
    }
}
