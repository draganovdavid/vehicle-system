<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
    'manufacturer',
    'model',
    'year',
    'kilometers'
];

}
