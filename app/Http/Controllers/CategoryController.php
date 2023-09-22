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

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = new CategoryRepository(new Category()); 
        $categories = $categories->filterBy($request->all());                
        return new CategoryCollection($categories->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Category/Form", [
            "method" => "post"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'required|string'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableEntity(
                $validator->errors()
            );
        }

        $category = new Category(); 
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();
        
        Logs::create(Category::class, "create new category");
        return ApiResponse::created("Successfully created category");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $category->with('posts')->get();

        return Inertia::render('Category/Show', [
            'category' => $category            
        ]);                
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render("Category/Form", [
            "method" => "put"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'required|string'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableEntity(
                $validator->errors()
            );
        }

        $category = new Category(); 
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();
        
        Logs::update(Category::class, "Updated the id: $category->id category");
        return ApiResponse::success("Successfully updated category");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {        
        $category->delete();
        Logs::delete(Category::class, "delete the id: $category->id category");
        return ApiResponse::noContent("Sucessfully deleted category");
    }
}
