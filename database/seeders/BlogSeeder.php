<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // default data dalam bahasa Inggris agar konsisten dengan factory
        $defaultData = [
            [
                'title' => 'Laravel Tips for Beginners',
                'description' => 'A simple and complete guide to get started with Laravel.',
                'category' => 'Tutorial',
                'color' => 'blue',
                'author' => 'YuukiYuna',
                'reading_time' => 8,
                'comments' => 4,
                'date' => now()->format('Y-m-d H:i:s'),
                'image' => 'https://picsum.photos/seed/default-1/800/400',
            ],
            [
                'title' => 'Getting Started with TablePlus',
                'description' => 'How to use TablePlus to manage your Laravel database easily.',
                'category' => 'Technology',
                'color' => 'green',
                'author' => 'Willi',
                'reading_time' => 6,
                'comments' => 7,
                'date' => now()->format('Y-m-d H:i:s'),
                'image' => 'https://picsum.photos/seed/default-2/800/400',
            ],
        ];

        if (Blog::count() === 0) {
            foreach ($defaultData as $row) {
                // gunakan create agar mass-assignment bekerja (pastikan $fillable di model)
                Blog::create($row);
            }
        }

        if (Blog::count() < 10) {
            Blog::factory()->count(10 - Blog::count())->create();
        }
    }
}
