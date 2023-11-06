<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

    public function getThumbAttribute()
    {
        return asset('storage/'.$this->attributes['thumb']);
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user', 'id');    
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function comments()
    {        
        return $this->hasMany(Comments::class, 'post', 'id');
    }

    public function like()
    {
        if(!auth()->check()) return false;
        
        $like = $this->hasMany(Like::class, 'post', 'id')
                     ->where('user', auth()->user()->id)
                     ->count();
        $this->setAttribute('like', $like);
    }

    public function likes()
    {        
        return $this->hasMany(Like::class, 'post', 'id');
    }

    public function preview()
    {
        $content = $this->attributes['content'];
        $content = substr($content, 0, 400);        
        $this->attributes['content'] = $content.'...';
    }

    public function related(int $limit = 3)
    {                                
        $category = $this->attributes['category'];        

        if(gettype($category) == "object") {
            $category = $category->id;
        }
        
        $related = $this->where('category', $category ?? 0)
                    ->with('user')
                    ->limit($limit)
                    ->get();

        $related->each(function($post) {
            $post->user = $post->user()->first();
            $post->category = $post->category()->first();
        });
        
        return $related;
    }
}
