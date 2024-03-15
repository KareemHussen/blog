<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $post_ids = DB::table('posts')->pluck('id')->toArray();

        return [
            'body' => $this->faker->sentence(5),
            "post_id" => $this->faker->randomElement($post_ids),
            "user_id" => 1
        ];
    }
}
