<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [
            '/images/img_snowtops.jpg',
            '/images/img_lights.jpg',
            '/images/img_forest.jpg',
            '/images/img_nature.jpg',
            '/images/img_mountains.jpg'
        ];

        $randomImage = $this->faker->randomElement($images);

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->realText(350),
            'full_image' => $randomImage,
            'thumbnail_image' => $randomImage,
            'user_id' => 1,
            'gallery_id' => 1,
        ];
    }
}
