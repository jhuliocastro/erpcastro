<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class Permissions extends Controller
{
    public function index(){
        $listUsers = User::all();
        $users = [];
        foreach($listUsers as $user){
            $users[] = [
                'id'=> $user->_id,
                'text' => $user->name
            ];
        }
        return view('Settings.Permissions.index', ['users' => $users]);
    }
}
