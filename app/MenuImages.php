<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuImages extends Model
{
    protected $fillable = [
        'path', 'menus_id'
    ];

    public function scopeMenu($query, $search)
    {
        if ($search != null) {
            if ($search != "0") {
                $query->where('menus_id', '=', $search);
            }
        }
    }

}
