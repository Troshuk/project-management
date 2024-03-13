<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use App\Enums\ProjectStatus;
use App\Traits\AuthorModel;
use App\Traits\ModelImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes, AuthorModel, ModelImage, Filterable, Sortable;

    protected $fillable     = ['name', 'description', 'status', 'due_date'];

    protected $casts        = [
        'status'   => ProjectStatus::class,
        'due_date' => 'date',
    ];

    protected $filterFields = [
        'name',
        'status',
    ];

    protected $sortFields   = [
        'id',
        'name',
        'status',
        'created_at',
        'due_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }
}
