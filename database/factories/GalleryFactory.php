<?php

namespace Database\Factories;

use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 year', '-1 month');
        $dayOffset = $this->faker->numberBetween(2, 10);
        $end = clone $start;
        $end->add(DateInterval::createFromDateString($dayOffset.' days'));

        $statuses = [ 'public', 'private'];

        return [
            'title' => $this->faker->sentence(),
            'status' => $this->faker->randomElement($statuses),
            'story' => $this->faker->realText(),
            'cover_image' => '/images/placeholder.png',
            'thumbnail_image' => '/images/placeholder.png',
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d'),
            'location' => $this->faker->city(),
            'latitude'      => $this->faker->latitude(-50,50),
            'longitude'      => $this->faker->longitude(-25, 25),
            'user_id' => 1,
        ];
    }
}
