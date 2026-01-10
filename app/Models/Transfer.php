<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'from_city',
        'to_city',
        'price',
        'description',
    ];

}
