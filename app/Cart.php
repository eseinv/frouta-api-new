<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\User;

class Cart extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = [
        'id', 'productId', 'quantity', 'userId', 'name', 'info', 'image', 'unitPrice', 'confirmed'
    ];

    protected $hidden = [

    ];

    public function owner(){
        return $this->belongsTo('App\User');
    }
}
