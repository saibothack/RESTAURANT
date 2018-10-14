<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
	public function scopeSearch($query, $search)
    {
        if (!empty(trim($search))) {
            $query->where('name', 'like', "%$search%");
        }
    }
    
    public static function defaultPermissions()
    {	
        return [           
            'Permisos',
            'Roles',
            'Usuarios',
            'Menu'
        ];
    }
}
