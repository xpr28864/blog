<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';

    protected $fillable = [
        'Region', 'district', 'address'
    ];

    protected $primaryKey = 'id';
}
