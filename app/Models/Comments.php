<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    public function getUserAttribute()
    {
        return User::find($this->attributes['user']);
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }    

    public function post() 
    {
        return $this->belongsTo(Post::class, 'post', 'id');
    }
    
}
