<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserUnitPreference extends Model
{
    // use HasFactory;

    protected $table = 'user_unit_preferences';

    protected $fillable = [
        'user_id',
        'item_unit_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemUnit()
    {
        return $this->belongsTo(ItemUnit::class, 'item_unit_id');
    }
}
