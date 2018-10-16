<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'title', 'description', 'price', 'active', 'restaurants_id', 'join'
    ];

    public function scopeSearch($query, $search)
    {
        if (!empty(trim($search))) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('domain', 'like', "%$search%");
        }
    }

    public function scopeActive($query, $search)
    {
        if ($search != "") {
            $query->where('active', '=', $search);
        }
    }

    public function scopeRestaurant($query, $search)
    {
        if ($search != null) {
            if ($search != "0") {
                $query->where('restaurants_id', '=', $search);
            }
        }
    }

    public function scopeImagesToMenu($id) {
        return MenuImages::menu($id)->get();
    }
}
