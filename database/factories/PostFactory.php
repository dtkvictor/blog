<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {        
        return [
            'user' => $this->randomUser(),
            'category' => $this->randomCategory(),
            'thumb' => fake()->imageUrl(),
            'title' => fake()->paragraph(1),
            'content' => fake()->text()
        ];
    }

    private function randomUser()
    {
        $user = User::all();
        $max = count($user) - 1;
        $rand = rand(0, $max);
        return $user[$rand]->id;
    }

    private function randomCategory()
    {
        $category = Category::all();
        $max = count($category) - 1;
        $rand = rand(0, $max);
        return $category[$rand]->id;
    }
}
