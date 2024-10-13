<?php

namespace getways\users\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
    protected $table = 'wallet_transactions';
    protected $guarded = [];
    protected $casts = [
        'action_at' => 'datetime',
    ];
    public function getImageUrlAttribute()
    {
        return ExistsImage($this->transfer_photo);
    }
    /********************************************* relations *********************************************/
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function payment_method(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function actionByAdmin()
    {
        return $this->belongsTo(Admin::class, 'action_by');
    }
    public function typeString()
    {
        return match ((int)$this->type) {
            1 => __('success'),
            2 => __('rejected'),
            default => __('pending'),
        };
    }
}


