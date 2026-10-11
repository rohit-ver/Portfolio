<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Experience::updateOrCreate(
            ['company' => 'Pratham Software Pvt. Ltd.'],
            [
                'designation' => 'Software Engineer (Laravel / PHP)',
                'location' => 'Jaipur, Rajasthan, India',
                'type' => 'Full-time',
                'start_date' => '2023-08-01',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Pratham Software Pvt. Ltd. (PSI) is a global IT services and consulting organization delivering mission-critical enterprise software solutions for international clients across North America, Europe, and Asia-Pacific.',
                'responsibilities' => [
                    'Architecting, developing, and deploying scalable web applications and enterprise portals using Laravel, PHP, and MySQL for international clients.',
                    'Designing high-performance RESTful APIs and microservice endpoints, implementing secure token authentication, rate limiting, and third-party webhook integrations.',
                    'Collaborating with cross-functional global teams, performing rigorous code reviews, optimizing database schemas, and ensuring CI/CD release reliability.',
                    'Refactoring legacy codebases into modern MVC architecture, boosting query execution performance by 40% and ensuring test coverage.',
                ],
                'tech_stack' => ['Laravel', 'PHP 8.2+', 'MySQL', 'RESTful APIs', 'Bootstrap 5', 'JavaScript', 'Git', 'Docker'],
                'sort_order' => 1,
            ]
        );
    }
}
