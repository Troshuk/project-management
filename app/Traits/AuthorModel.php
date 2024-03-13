<?php

namespace App\Traits;

use App\Models\User;

trait AuthorModel
{
    /**
     * @return void
     */
    public static function bootAuthorModel(): void
    {
        if ($userId = \Illuminate\Support\Facades\Auth::id()) {
            static::creating(function ($model) use ($userId) {
                if (! $model->isDirty($this->getCreatedByColumn())) {
                    $model->created_by = $userId;
                }
            });

            static::saving(function ($model) use ($userId) {
                if (! $model->isDirty($this->getUpdatedByColumn())) {
                    $model->updated_by = $userId;
                }
            });

            static::deleting(function ($model) use ($userId) {
                if (! $model->isDirty($this->getUpdatedByColumn())) {
                    $model->updated_by = $userId;
                }
            });
        }
    }

    /**
     * Get the name of the "created_by" column.
     *
     * @return string
     */
    protected function getCreatedByColumn(): string
    {
        return defined(static::class . '::CREATED_BY') ? static::CREATED_BY : 'created_by';
    }

    /**
     * Get the name of the "updated_by" column.
     *
     * @return string
     */
    protected function getUpdatedByColumn(): string
    {
        return defined(static::class . '::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, $this->getCreatedByColumn());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, $this->getUpdatedByColumn());
    }
}
