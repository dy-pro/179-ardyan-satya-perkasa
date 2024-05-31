<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'measurement_time',
        'value',
        'value_systolic',
        'value_diastolic',
        'note',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($measurement) {
            $bloodPressureType = MeasurementType::where('name', 'Blood Pressure')->first();

            if ($measurement->type_id == $bloodPressureType->id) {
                if (is_null($measurement->value_systolic) || is_null($measurement->value_diastolic)) {
                    throw new \Exception('Systolic and diastolic values are required for blood pressure measurements.');
                }
            } else {
                $measurement->value_systolic = null;
                $measurement->value_diastolic = null;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(MeasurementType::class, 'type_id');
    }

    public function detail()
    {
        return $this->hasOne(MeasurementDetail::class);
    }
}
