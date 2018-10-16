<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
    protected $fillable = [
        'name', 'price', 'type'
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
}
