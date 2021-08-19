<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','UAN', 'email', 'password', 'UDT', 'parent_id', 'UJT', 'UZS', 'UZA', 'UCN','CZN','CMT','CMA','CMN','CMB','CBK','UTV', 'usertype',
        'BPA','BPB','BPC','BPD','BPE','BPF','BPG','BPH','BPI','BPJ','BPJ1','BPJ2','BPK','BPL','RBA','RBA1'
        ,'RBA2','RBA3','RBA4','RBA4A','RBB'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
