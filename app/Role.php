<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    public function scopeSearch($query, $search)
    {
        if (!empty(trim($search))) {
            $query->where('name', 'like', "%$search%");
        }
    }
}
