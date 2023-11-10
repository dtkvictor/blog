<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Category;

class CheckCategory implements ValidationRule
{
    private $category;

    public function __construct($category) {
        $this->category = $category;        
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->category->name == $value) return;        
        if(Category::where('name', $value)->limit(1)->count() >= 1) {
            $fail("This category already exists.");
        }        
    }
}
