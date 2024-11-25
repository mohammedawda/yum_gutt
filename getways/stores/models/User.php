<?php

namespace getways\stores\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    const ADMIN_ROLE = 1;
    const STORE_ROLE = 2;
    const USER_ROLE  = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'random_password',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'action_at'         => 'datetime',
    ];

    public function getNationalIdPhotoUrlAttribute($value): string
    {
        return !is_null($value) ? GetFile(FileDir('user_images').$value) : null;
    }

    public function getProfilePhotoAttribute($value): string
    {
        return !is_null($value) ? GetFile(FileDir('profile_photo').$value) : null;
    }
    /********************************************* scopes *********************************************/
    public function scopeCountryId($query)
    {
        return $query->where('country_id', config('app.country_id'));
    }

    public function scopeAllStores($query)
    {
        return $query->where('role_id', User::STORE_ROLE);
    }

    public function scopeAllUsers($query)
    {
        return $query->where('role_id', User::USER_ROLE);
    }
    /********************************************* relations *********************************************/
    public function store()
    {
        return $this->hasOne(Store::class);
    }
}
