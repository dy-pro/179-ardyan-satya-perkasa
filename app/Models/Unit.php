<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit',
        'description',
    ];

    public function measurementTypes(): BelongsToMany
    {
        return $this->belongsToMany(MeasurementType::class, 'item_units', 'unit_id', 'type_id')
                    ->using(ItemUnit::class);
    }
}
