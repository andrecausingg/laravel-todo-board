<?php

namespace App\Models\V1\System\Todo;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TodoModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'todo_tbl';
    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid_todo_id',

        'created_by_number_user_id',
        'created_by_uuid_user_id',

        'title',
        'description',
        'status',

        'expired_at',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
        'deleted_at'         => 'datetime',

        'expired_at'  => 'datetime',
    ];

    protected $hidden = [
        'created_by_number_user_id',
        'created_by_uuid_user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid_todo_id)) {
                do {
                    $uuid = Uuid::uuid7()->toString();
                } while (static::where('uuid_todo_id', $uuid)->exists());

                $model->uuid_todo_id = $uuid;
            }
        });
    }
}
