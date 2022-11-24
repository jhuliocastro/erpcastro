<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class LoginModel extends Model
{
    use HasFactory;
    protected $collection = 'users';
    protected $primaryKey = 'id';

    public static function login(string $user, string $password){

    }
}
