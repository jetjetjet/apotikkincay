<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\LogUser;

class User extends Authenticatable
{
    use HasApiTokens, LogUser, HasRoles;
    protected $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'nama_lengkap',
        'password',
        'email',
        'alamat',
        'kontak',
        'jen_kel',
        'tgl_masuk',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
