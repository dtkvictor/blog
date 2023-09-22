<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',        
        'content'
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    
    public function getCategoryAttribute()
    {
        return Category::find($this->attributes['category']);
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user', 'id');    
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function comments(int $limit = 5)
    {        
        $comments = Comments::where('post', $this->attributes['id'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)            
            ->get();
        $this->setAttribute("comments", $comments);
    }

    public function like()
    {
        $user = auth()->user()->id ?? false;
        if(!$user) {
            $this->setAttribute('like', false);   
        }else {
            $like = Like::where('user', $user)
                ->where('post', $this->attributes['id'])
                ->count();
            $this->setAttribute('like', $like);
        }        
    }

    public function related(int $limit = 3)
    {        
        $related = $this->where('category', $this->attributes['category'])
            ->with('user')
            ->limit($limit)
            ->get();
        $this->setAttribute('related', $related);
    }
}