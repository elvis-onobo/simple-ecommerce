<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /*
    * Mass assigned values
    */
    protected $fillable = [
        'user_id', 'balance', 'reference', 'authorization', 'nature_of_tranx'
    ];
}
