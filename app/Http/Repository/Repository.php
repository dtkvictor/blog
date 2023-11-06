<?php 
namespace App\Http\Repository;
use Illuminate\Database\Eloquent\Model;

abstract class Repository 
{
    protected $model;
    protected array $supportedFilters = [
        'id' => 'filterById',  
        'slug' => 'filterBySlug',                
        'date' => 'filterByDate',
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

    public function filterBySlug(string $slug)
    {
        return $this->model->where('slug', $slug);
    }    

    public function filterByDate(string $date)
    {
        return $this->model->where('created_at', $date);
    }    

    protected function supportFilterByString(string $field, string $value)
    {
        $words = preg_split('/(\-|\s+)/', $value);        
        $model = $this->model->where($field, $value);

        foreach($words as $word) {
            $model = $model->orWhere($field, "LIKE", "%$word%");
        }                        
        return $model;
    }
    
    protected function supportFilterOrderBy(array $orderBySuported, object $model, string $key)
    {
        $suported = [            
            'created' => ['created_at', 'DESC'],
            'updated' => ['updated_at', 'DESC'],            
            ...$orderBySuported
        ];
        if(!isset($suported[$key])) return $this->model;                        
        return $model->orderBy(...$suported[$key]);        
    }

}