<?php

namespace BandManager\App\Models;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as DBAuthenticable;
use \Illuminate\Foundation\Auth\Access\Authorizable as DBAuthorizable;
//use Illuminate\Auth\Passwords\CanResetPassword as DBPasswordReset;
//use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Model implements Authenticatable, Authorizable
{
    use HasFactory, DBAuthorizable, DBAuthenticable;

    public const TABLE_NAME = 'users';

    protected $table = self::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'display_name',
        'fb_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function getDisplayName(): string
    {
        return $this->display_name;
    }
}
