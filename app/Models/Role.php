<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Role extends \Spatie\Permission\Models\Role
{
	protected $guarded = [];
    protected $fillable = ['name'];    
    protected $dates = ['deleted_at'];
    protected $table = "roles";

    const SUPER_ADMIN = 'super_admin';
    const ADMIN = 'admin';
    const USER = 'user';
    const SUPERVISOR = 'supervisor';

    public function scopePermitedRoles($query){
        $role = self::SUPER_ADMIN;
        if ( !is_null(Auth::user()) && Auth::user()->hasRole($role) )
             return $query;
        else
            return $query->where('name','!=',Role::SUPER_ADMIN);
    }
}
