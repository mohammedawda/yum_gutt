<?php

namespace getways\users\models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
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

    public function getNationalIdPhotoUrlAttribute()
    {
        return !is_null($this->national_id_photo) ? GetFile(FileDir('user_images').$this->national_id_photo) : null;
    }

    public function getProfilePhotoAttribute($value)
    {
        return !is_null($value) ? GetFile(FileDir('profile_photo').$value) : null;
    }

    public function deposit_wallet($amount,$desc)
    {
        $this->increment('wallet', $amount);
        $this->wallets()->create([
           'value'=>$amount,
            'desc'=>$desc,
            'type'=>'0'
        ]);
    }
    public function purchase_wallet($amount,$desc)
    {
        $this->decrement('wallet', $amount);
        $this->wallets()->create([
           'value'=>-$amount,
            'desc'=>$desc,
            'type'=>'1'
        ]);
    }
    public function withdrew_wallet($amount,$desc)
    {
        $this->decrement('wallet', $amount);
        $this->wallets()->create([
           'value'=>-$amount,
            'desc'=>$desc,
            'type'=>'1'
        ]);
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

    public function scopeAllAdmins($query)
    {
        return $query->where('role_id', User::ADMIN_ROLE);
    }
    /********************************************* relations *********************************************/
    public function City(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function wallets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function actionByAdmin()
    {
        return $this->belongsTo(User::class, 'action_by');
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function reels()
    {
        return $this->hasMany(Reel::class, 'owner_id');
    }
}
