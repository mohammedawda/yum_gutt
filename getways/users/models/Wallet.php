<?php

namespace getways\users\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function typeString()
    {
        return match ($this->type) {
            1 => __('sell'),
            2 => __('withdrew'),
            default => __('deposit'),
        };
    }
}
