<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentsFactory extends Factory
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
            'post' => $this->randomPost(),
            'text' => fake()->paragraph()
        ];
    }

    private function randomUser()
    {
        $user = User::all();
        $max = count($user) - 1;
        $rand = rand(0, $max);
        return $user[$rand]->id;
    }

    private function randomPost()
    {
        $post = Post::all();
        $max = count($post) - 1;
        $rand = rand(0, $max);        
        return $post[$rand]->id;
    }
}
