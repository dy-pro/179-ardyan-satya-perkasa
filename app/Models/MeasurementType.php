<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MeasurementType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
    ];

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'item_units', 'type_id', 'unit_id')
                    ->using(ItemUnit::class);
    }
}
