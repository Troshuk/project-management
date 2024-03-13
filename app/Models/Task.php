<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Traits\AuthorModel;
use App\Traits\ModelImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes, AuthorModel, ModelImage, Filterable, Sortable;

    protected $fillable     = [
        'name',
        'description',
        'status',
        'priority',
        'due_date',
        'assigned_user_id',
        'project_id',
    ];

    protected $casts        = [
        'status'   => TaskStatus::class,
        'priority' => TaskPriority::class,
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
