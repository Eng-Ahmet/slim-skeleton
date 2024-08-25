<?php

declare(strict_types=1);

namespace API\src\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'username',
        'password',
        'gender',
        'status',
        'account_type',
        'login_attempts',
        'preferences',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'preferences' => 'json',
    ];

    public $timestamps = true;
}
