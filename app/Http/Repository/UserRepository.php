<?php 

namespace App\Http\Repository;

class UserRepository extends Repository
{ 	
    public function filterByName(string $name)
    {
        return $this->supportFilterByString('name', $name);
    }

	public function filterByAdmin(bool $admin)
	{
		return $this->model->where('admin', $admin);
	}

	public function filterByMinPost(int $min)
	{
		return $this->model->whereHas('post', function($query) use ($min) {
			$query->havingRaw("COUNT(*) >= $min");
		});
	}

	public function filterByMaxPost(int $max)
	{
		return $this->model->whereHas('post', function($query) use ($max) {
			$query->havingRaw("COUNT(*) <= $max");
		});
	}

	protected function addSuportedFilters(): array
	{
		 return [
			'name' => 'filterByName',
			'admin' => 'filterByAdmin',			
			'min' => 'filterByMinPost',
			'max' => 'filterByMaxPost',
		 ];
	}
}