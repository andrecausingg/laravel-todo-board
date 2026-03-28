<?php

namespace App\Models\V1\System\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UsersAccountModel extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $table = 'users_account_tbl';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid_user_id',

        'created_by_number_user_id',
        'created_by_uuid_user_id',

        'email',

        'password',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
        'deleted_at'         => 'datetime',
    ];


    /**
     * Summary of boot
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid_user_id)) {
                do {
                    $uuid = Uuid::uuid7()->toString();
                } while (static::where('uuid_user_id', $uuid)->exists());

                $model->uuid_user_id = $uuid;
            }
        });

        static::saving(function ($model) {
            $model->password = Hash::make($model->password);
        });
    }


    /**
     * Get all attributes
     * 
     * Summary of getFillableAttributes
     * @return array
     */
    public function getFillableAttributes()
    {
        return array_merge($this->fillable, ['id']);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getAttribute('uuid_user_id');
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id_2' => $this->uuid_user_id ? Crypt::encrypt($this->uuid_user_id) : null,
        ];
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'uuid_user_id';
    }
}
