<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'car_model_id',
        'year',
        'km',
    ];

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function manufacturer()
    {
        return $this->model->manufacturer();
    }

}
