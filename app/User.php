<?php

namespace App;

use Illuminate\Auth\Passwords\CanResetPassword;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;


use UserRole;

class User extends Authenticatable
{

    use EntrustUserTrait; // add this trait to your user model

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAtributte($pass){
        if(!empty($pass)){
            $this->attributes['password'] = \Hash::make($pass);
        }
    }

    public function isAdmin()
    {   //hacer logica para retornar si es un admin mirando tabla role_user y role 
        //$role=UserRole::find($this);        
        
        $isAdmin=$this->hasRole('admin');
        
        return $isAdmin?$isAdmin:false;
    }

}