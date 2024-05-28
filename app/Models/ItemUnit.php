<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class ItemUnit extends Pivot
{
    // use HasFactory;

    protected $fillable = [
        'type_id',
        'unit_id',
    ];

    public function measurementType()
    {
        return $this->belongsTo(MeasurementType::class, 'type_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
