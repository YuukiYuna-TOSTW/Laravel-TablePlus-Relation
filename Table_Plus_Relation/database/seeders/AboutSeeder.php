<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Project;

class AboutSeeder extends Seeder
{
    public function run()
    {
        About::create([
            'title' => 'Tentang Saya',
            'content' => 'Saya adalah seorang developer yang suka belajar hal baru.',
            'experience_id' => Experience::first()->id ?? null,
            'skill_id' => Skill::first()->id ?? null,
            'project_id' => Project::first()->id ?? null,
        ]);
    }
}
