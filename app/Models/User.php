<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Role;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
    protected $appends = ['fullname','isAdmin','isSuperAdmin'];

    public function getFullnameAttribute(){
        return implode(", ",[ implode(" ",[$this->paterno,$this->materno]) , $this->nombre]); 
    }

    public function getIsAdminAttribute(){
        //return $this->hasAnyRole(Role::ADMIN, Role::SUPER_ADMIN);
        return $this->hasAnyRole(Role::ADMIN);
    }

    public function getIsSuperAdminAttribute(){
        return $this->hasAnyRole(Role::SUPER_ADMIN);
    }

}
