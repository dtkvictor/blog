<?php 
namespace App\Http\Repository;
use Illuminate\Database\Eloquent\Model;

abstract class Repository 
{
    protected $model;
    protected array $supportedFilters = [
        'id' => 'filterById'        
    ];
    
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->supportedFilters = array_merge(
            $this->supportedFilters,
            $this->addSuportedFilters()
        );                
    }

    protected function addSuportedFilters(): array
    {
        return [];
    }

    public function filterBy(array $filters) 
    {               
        foreach($this->supportedFilters as $key => $filter) {                            
            if(!isset($filters[$key])) continue;            
            $this->model = call_user_func([$this, $filter], $filters[$key]);
        }
        return $this->model;
    }

    public function filterById(int $id) 
    {
        return $this->model->where('id', $id);
    }

}