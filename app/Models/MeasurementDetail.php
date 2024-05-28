<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'measurement_id',
        'after_meal',
        'location',
        'device',
    ];

    public function measurement()
    {
        return $this->belongsTo(Measurement::class);
    }
}
