<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function author() 
    {        
        $user = User::has('post')->get();
        return new UserCollection($user);
    }
}
