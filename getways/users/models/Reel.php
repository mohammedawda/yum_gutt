<?php

namespace getways\users\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reel extends Model
{
    use SoftDeletes;

    protected $table = 'reels';
}
