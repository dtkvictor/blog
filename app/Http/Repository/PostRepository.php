<?php
namespace App\Http\Repository;

use App\Models\Category;
use App\Models\User;

class PostRepository extends Repository 
{        
    public function filterByAuthor(string $author) 
    {        
        $model = $this->model;
        $authors = User::where('slug', $author)->whereHas('post')->get();

        if($authors->count() < 1) {
            $model = $model->where('user', 0);
        } 

        foreach ($authors as $author) {            
            $model = $model->where("user", $author->id);
        }

        return $model;
    }
    
    public function filterByCategory(string $category)
    {
        $category = Category::where('slug', $category)->first();
        return $this->model->where('category', $category->id ?? 0);
    }

    public function filterByTitle(string $title)
    {
        return $this->supportFilterByString('title', $title);
    }

    public function filterOrderBy(string $key)
    {
        $suported = [
            'title' => ['title', 'ASC'],            
            'relevance' => ['likes_count', 'DESC'],
        ];
        if($key == 'relevance') {
            $this->model = $this->model->withCount('likes');
        }        
        return $this->supportFilterOrderBy($suported, $this->model, $key);
    }

    protected function addSuportedFilters(): array
    {
        return [            
            'slug' => 'filterBySlug',
            'title' => 'filterByTitle',
            'author' => 'filterByAuthor',
            'category' => 'filterByCategory',
            'orderBy' => 'filterOrderBy',
        ];
    }

}