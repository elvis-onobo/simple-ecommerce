<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /*
    * Mass assign
    */
    protected $fillable = ['user_id', 'product_id'];
}
