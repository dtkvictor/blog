<?php

namespace Database\Factories;

use App\Models\Log;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Logs>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actions = Log::getActions();
        $action = $actions[rand(0, 2)];

        return [
            'user' => User::first()->id, 
            'action' => $action,
            'model' => Post::class,
            'message' => fake()->paragraph()
        ];        
    }
}
