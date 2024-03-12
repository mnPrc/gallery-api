<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GalleriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Gallery::factory()->count(30)->create();

        // Gallery::all()->each(function ($gallery) {
        //     $firstImage = $gallery->images()->first();

        //     if($firstImage){
        //         $firstImageUrl = $firstImage->imageUrl;
        //         $gallery->update(['first_image_url' => $firstImageUrl]);
        //     }else{
        //         $gallery->update(['first_image_url' => 'https://picsum.photos/300/300.jpg']);
        //     }
        // });
    }
}
