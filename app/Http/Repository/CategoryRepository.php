<?php 

namespace App\Http\Repository;

class CategoryRepository extends Repository
{ 
	public function filterBySlug(string $slug)
    {
        return $this->supportFilterByString('slug', $slug);
    }

    public function filterOrderBy(string $key)
    {
        $suported = [
            'name' => ['name', 'ASC'],
        ];        
        return $this->supportFilterOrderBy($suported, $this->model, $key);
    }

    protected function addSuportedFilters(): array
    {
        return [            
            'name' => 'filterBySlug',
            'orderBy' => 'filterOrderBy',
        ];
    }
}