<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Repository\CategoryRepository;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Http\Helpers\Logs;
use App\Http\Resources\CategoryCollection;
use App\Http\Helpers\Generic;

class CategoryController extends Controller
{      
    /**
     * Lists the categories and returns a json.
     */    
    public function list()
    {
        $categories = Category::orderBy('updated_at', 'DESC')->get();
        return new CategoryCollection($categories);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $any = '')
    {
        $filters = Generic::stringToArrayAssociative($any);

        if(!isset($filters['orderBy'])) {
            $filters['orderBy'] = 'created';
        }

        $categories = new CategoryRepository(new Category()); 
        $categories = $categories->filterBy($filters);
        $categories = $categories->paginate(10)
                                 ->onEachSide(1);

        return Inertia::render('Category/Index', [
            'response' => $categories
        ]);
    }        

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {    
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'required|string|max:500'
        ]);                
        Category::create($data);    
        Logs::create(Category::class, "create new category");        
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {                
        if(!$category = Category::find($id)) {
            return back()->withErrors(['erro' => 'Category not found']);
        }
        
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'required|string|max:500'
        ]);                

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();
        
        Logs::update(Category::class, "Updated the id: $category->id category");        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {                   
        if(!$category = Category::find($id)) {
            return back()->withErrors(['erro' => 'Category not found']);
        } 
        $category->delete();
        Logs::delete(Category::class, "delete the id: $category->id category");
    }
}
