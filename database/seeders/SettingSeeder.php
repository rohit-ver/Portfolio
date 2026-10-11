<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Hero & Profile
            ['key' => 'hero_title', 'value' => 'Hi, I\'m', 'group' => 'hero'],
            ['key' => 'hero_name', 'value' => 'Rohit Verma', 'group' => 'hero'],
            ['key' => 'designation', 'value' => 'PHP & Laravel Developer', 'group' => 'hero'],
            ['key' => 'hero_intro', 'value' => 'I build dynamic, responsive and database-driven web applications with PHP and Laravel, focused on practical solutions to real-world problems.', 'group' => 'hero'],
            ['key' => 'typing_roles', 'value' => 'Laravel Developer, PHP Developer, Web Application Developer', 'group' => 'hero'],
            ['key' => 'profile_image', 'value' => null, 'group' => 'hero'],
            ['key' => 'open_to_work', 'value' => '1', 'group' => 'hero'],

            // About Section (Exact user specifications)
            ['key' => 'about_short', 'value' => 'I\'m a passionate PHP and Laravel developer who enjoys building dynamic, responsive and database-driven web applications that solve real-world problems. I\'ve worked on admin dashboards, authentication, product management and customer inquiry systems. I hold a BCA degree and keep improving my problem-solving skills. Alongside development, I work at Pratham Software in sales and lead generation.', 'group' => 'about'],
            ['key' => 'education', 'value' => 'Bachelor of Computer Applications (BCA)', 'group' => 'about'],
            ['key' => 'stats_projects', 'value' => '3', 'group' => 'about'],
            ['key' => 'stats_tech', 'value' => '10+', 'group' => 'about'],

            // Contact & Info
            ['key' => 'owner_email', 'value' => 'rohitv3319@gmail.com', 'group' => 'contact'],
            ['key' => 'owner_phone', 'value' => '+91 6378156855', 'group' => 'contact'],
            ['key' => 'whatsapp_number', 'value' => '6378156855', 'group' => 'contact'],
            ['key' => 'location', 'value' => 'Rajasthan, India', 'group' => 'contact'],
            ['key' => 'availability_status', 'value' => 'Available for Full-time Roles & High-Impact Freelance Projects', 'group' => 'contact'],

            // Social Links (GitHub, LinkedIn, Instagram, X)
            ['key' => 'social_github', 'value' => 'https://github.com/rohitv3319', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://www.linkedin.com/in/rohit-verma', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => '', 'group' => 'social'],

            // SEO & Branding (Exact user specifications)
            ['key' => 'meta_title', 'value' => 'Rohit Verma | PHP & Laravel Developer Portfolio', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Portfolio of Rohit Verma, a PHP & Laravel developer building dynamic, database-driven web apps with MySQL, Filament and JavaScript.', 'group' => 'seo'],
            ['key' => 'meta_og_image', 'value' => '', 'group' => 'seo'],

            // Footer
            ['key' => 'footer_tagline', 'value' => 'Building practical Laravel web applications that solve real problems.', 'group' => 'footer'],
            ['key' => 'footer_about', 'value' => 'PHP & Laravel developer passionate about building dynamic web solutions and efficient backends.', 'group' => 'footer'],
            ['key' => 'footer_copyright', 'value' => '© 2026 Rohit Verma. All rights reserved.', 'group' => 'footer'],
        ];

        foreach ($settings as $s) {
            Setting::set($s['key'], $s['value'], $s['group']);
        }

        Setting::clearAllCache();
    }
}