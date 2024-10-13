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
        'action_at' => 'datetime',
    ];
    public function getNameAttribute()
    {
        return $this->first_name .' '. $this->last_name;
    }

    public function getNationalIdPhotoUrlAttribute(): string
    {
        return ExistsImage($this->nationalId_photo);
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
    /********************************************* relations *********************************************/
    public function City(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function addresses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserAddress::class);
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
}
