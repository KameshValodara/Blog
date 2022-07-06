<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $noteable = [
            \App\Models\Member::class,
            \App\Models\Post::class,
        ];

        return [
            'url' => $this->faker->imageUrl($width = 640 , $height = 480),
            'imagable_id' => $this->faker->numberBetween(1,10),
            'imagable_type' => $this->faker->randomElement($noteable),
        ];
    }
}
