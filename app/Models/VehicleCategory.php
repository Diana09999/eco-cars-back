<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price_factor'];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'category_id');
    }
}
