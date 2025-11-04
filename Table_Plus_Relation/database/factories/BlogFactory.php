<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        // pastikan menggunakan Faker locale en_US secara eksplisit
        $fakerEn = \Faker\Factory::create('en_US');

        $title = $fakerEn->sentence();
        $seed  = Str::slug($title) . '-' . $fakerEn->unique()->numberBetween(1, 9999);

        return [
            'title' => $title,
            'description' => $fakerEn->paragraph(),
            // gunakan label kategori dalam bahasa Inggris
            'category' => $fakerEn->randomElement(['Tutorial','Technology','Tips','Update']),
            'color' => $fakerEn->randomElement(['blue','green','red','yellow']),
            'author' => $fakerEn->name(),
            'reading_time' => $fakerEn->numberBetween(1,15),
            'comments' => $fakerEn->numberBetween(0,30),
            'date' => $fakerEn->dateTimeBetween('-1 year','now')->format('Y-m-d H:i:s'),
            'image' => "https://picsum.photos/seed/{$seed}/800/400",
        ];
    }
}
