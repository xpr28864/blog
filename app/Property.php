<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property';

    protected $fillable = [
        'user', 'location', 'property_name', 'transaction_type', 'property_type', 'property_size', 'price'
    ];

    protected $primaryKey = 'id';
}
