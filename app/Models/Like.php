<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;   
    
    protected $fillable = [
        'user',
        'post'    
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post', 'id');
    }

    public static function  getByPostAndUserAuth(int $post)
    {
        if(!auth()->check()) return false;        
        return Like::where('post', $post)
                   ->where('user', auth()->user()->id)
                   ->count();
    }
}
