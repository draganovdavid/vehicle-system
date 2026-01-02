<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = ['name', 'founded_at'];

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
