<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only skills from user profile; proficiency left null as specified
        $skills = [
            [
                'name' => 'PHP',
                'category' => 'Backend',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-filetype-php',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Laravel',
                'category' => 'Backend',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-fire',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'MySQL',
                'category' => 'Database',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-database',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Filament',
                'category' => 'Backend',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-layout-wtf',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'JavaScript',
                'category' => 'Frontend',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-filetype-js',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'jQuery',
                'category' => 'Frontend',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-code-slash',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'AJAX',
                'category' => 'Frontend',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-arrow-repeat',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'HTML',
                'category' => 'Frontend',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-filetype-html',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'CSS',
                'category' => 'Frontend',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-filetype-css',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Git',
                'category' => 'Tools',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-git',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'GitHub',
                'category' => 'Tools',
                'icon_type' => 'class',
                'icon_class' => 'bi bi-github',
                'icon_image' => null,
                'proficiency' => null,
                'sort_order' => 11,
                'is_active' => true,
            ],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                $skill
            );
        }
    }
}
