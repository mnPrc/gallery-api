<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Gallery;
use App\Models\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    protected $model = Gallery::class;
   /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->realText(15),
            'description' => $this->faker->realText(50),
            'price' => $this->faker->randomFloat(2, 0, 10000),
            'user_id' => \App\Models\User::all()->random()->id,
            // 'first_image_url' => function () {
            //     $image = Image::where('gallery_id', $this->faker->unique()->numberBetween(1, 100))->first();
            //     return $image ? $image->imageUrl : null;
            // },
        ];
    }
}
