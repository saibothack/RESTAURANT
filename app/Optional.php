<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
    protected $fillable = [
        'name', 'price', 'type', 'restaurants_id'
    ];

    public function scopeSearch($query, $search)
    {
        if (!empty(trim($search))) {
            $query->where('name', 'like', "%$search%");
        }
    }

    public function scopeType($query, $search)
    {
        if ($search != "") {
            $query->where('type', '=', $search);
        }
    }

    public function scopeResturant($query, $search)
    {
        if ($search != null) {
            $query->where('restaurants_id', '=', $search);
        }
    }
}
