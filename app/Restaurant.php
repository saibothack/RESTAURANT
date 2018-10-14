<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'name', 'domain', 'email', 'active', 'payment_day', 'days_grace', 'tables', 'price', 'images'
    ];

    public function scopeSearch($query, $search)
    {
        if (!empty(trim($search))) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('domain', 'like', "%$search%");

        }
    }

    public function scopeActive($query, $search)
    {
        if ($search != null) {
            $query->where('active', '=', $search);
        }
    }
}
