<?php
namespace App\Http\Repository;

use App\Models\Category;
use App\Models\User;

class PostRepository extends Repository 
{    
    public function filterByTitle(string $title) 
    {
        $words = preg_split('/(\-|\s+)/', $title);        
        $model = $this->model->where('title', $title);
        foreach($words as $word) {
            $model = $model->orWhere("title", "LIKE", "%$word%");
        }                        
        return $model;
    }

    public function filterBySlug(string $slug)
    {
        return $this->model->where("slug", "LIKE", "%$slug%");
    }

    public function filterByAuthor(string $author) 
    {
        $author = User::where('slug', $author)->first();
        return $this->model->where("user", $author->id ?? 0);
    }
    
    public function filterByCategory(string $category)
    {
        $category = Category::where('slug', $category)->first();
        return $this->model->where('category', $category->id ?? 0);
    }

    protected function addSuportedFilters(): array
    {
        return [            
            'slug' => 'filterBySlug',
            'title' => 'filterByTitle',
            'author' => 'filterByAuthor',
            'category' => 'filterByCategory'
        ];
    }

}