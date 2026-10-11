<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Cleaning Drive Website',
                'slug' => 'cleaning-drive-website',
                'category' => 'Social Initiative & NGO',
                'description' => 'A dynamic social initiative and cleanliness drive platform built to mobilize volunteer participation, organize city-wide hygiene campaigns, and showcase community impact in real-time.',
                'long_description' => 'A purpose-driven digital platform developed for Kartavyya to empower urban cleanliness movements. The system includes volunteer registration, community campaign scheduling, live event tracking, media photo galleries of past drives, and an automated donation/contribution workflow. Optimized for swift mobile responsiveness and seamless social sharing.',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Bootstrap 5', 'JavaScript', 'Blade'],
                'image' => '/images/projects/kartavyya.svg',
                'live_url' => 'https://kartavyya.com/',
                'github_url' => 'https://github.com/rohitv3319', // Replace with specific repo if public
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'B2B E-commerce Website (Headway)',
                'slug' => 'b2b-ecommerce-headway',
                'category' => 'Enterprise E-Commerce',
                'description' => 'A robust B2B wholesale platform featuring multi-tiered commercial pricing, bulk order processing, corporate credit accounts, tax invoicing, and sophisticated catalog management.',
                'long_description' => 'Headway is an enterprise-grade wholesale B2B marketplace engine tailored for distributor-to-retailer transactions. It features custom bulk quotation requests, tiered volume discounting, invoice generation, customer business verification, real-time inventory threshold alerts, and a modular admin command center built on Laravel and MySQL.',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Bootstrap 5', 'JavaScript', 'Blade', 'REST API'],
                'image' => '/images/projects/headway.svg',
                'live_url' => null, // Private / Internal enterprise deployment
                'github_url' => 'https://github.com/rohitv3319',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Car Rental Website',
                'slug' => 'car-rental-website',
                'category' => 'Automotive & Booking',
                'description' => 'A full-featured vehicle booking and fleet management system providing seamless car discovery, automated date/time reservation checks, customer portal, and back-office management.',
                'long_description' => 'An end-to-end car rental solution delivering dynamic vehicle catalog filtering (by brand, transmission, fuel type, seating capacity), interactive date/time reservation engine with automated price calculations, customer driving license verification, maintenance log tracking, and comprehensive booking lifecycle management.',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Bootstrap 5', 'JavaScript', 'Blade'],
                'image' => '/images/projects/car-rental.svg',
                'live_url' => null,
                'github_url' => 'https://github.com/rohitv3319',
                'is_featured' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }
    }
}
