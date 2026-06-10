<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Application;
use App\Models\EmployerRequest;
use App\Models\Expert;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
    ['email' => 'admin@praktix.al'],
    [
        'name'     => 'Praktix Admin',
        'password' => Hash::make('praktix2024'),
    ]
);

        // ── Experts ────────────────────────────────────────────────────────────
        $experts = [
            [
                'name'           => 'Andi Metani',
                'title'          => 'Senior Data Scientist',
                'specialization' => 'Machine Learning & AI',
                'experience'     => 8,
                'bio'            => 'Andi has 8 years of experience in ML and AI, having worked with leading tech companies in Europe. He specializes in building production-grade ML pipelines and NLP systems.',
                'profile_image'  => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'name'           => 'Erida Hoxha',
                'title'          => 'Full-Stack Engineer',
                'specialization' => 'Web Development & APIs',
                'experience'     => 6,
                'bio'            => 'Erida is a full-stack engineer with deep expertise in Laravel, React, and cloud architecture. She has led engineering teams across multiple startups in the Western Balkans.',
                'profile_image'  => 'https://randomuser.me/api/portraits/women/44.jpg',
            ],
            [
                'name'           => 'Besnik Leka',
                'title'          => 'Product & UX Lead',
                'specialization' => 'Product Design & Strategy',
                'experience'     => 10,
                'bio'            => 'Besnik has a decade of experience in product management and UX design, working across fintech, edtech, and e-commerce. He helps teams build products users love.',
                'profile_image'  => 'https://randomuser.me/api/portraits/men/56.jpg',
            ],
            [
                'name'           => 'Mirela Duka',
                'title'          => 'Cybersecurity Specialist',
                'specialization' => 'Security & DevSecOps',
                'experience'     => 7,
                'bio'            => 'Mirela is a certified cybersecurity professional with experience in penetration testing, cloud security, and compliance frameworks such as ISO 27001 and SOC 2.',
                'profile_image'  => 'https://randomuser.me/api/portraits/women/68.jpg',
            ],
        ];

        $createdExperts = [];
        foreach ($experts as $expertData) {
            $createdExperts[] = Expert::create($expertData);
        }

        // ── Programs ───────────────────────────────────────────────────────────
        $programs = [
            [
                'title'                => 'AI & Machine Learning Bootcamp',
                'category'             => 'Artificial Intelligence',
                'description'          => 'A hands-on intensive program covering supervised and unsupervised learning, neural networks, NLP, and deploying ML models in production. You will work on real-world projects with industry data.',
                'duration'             => '3 months',
                'price'                => 890.00,
                'image_url'            => 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01',
                'expert_id'            => $createdExperts[0]->id,
                'certificate_included' => true,
            ],
            [
                'title'                => 'Full-Stack Web Development',
                'category'             => 'Software Development',
                'description'          => 'Master Laravel for backend and React for frontend. Build complete web applications from database design to deployment. Covers REST APIs, authentication, and cloud hosting.',
                'duration'             => '4 months',
                'price'                => 750.00,
                'image_url'            => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479',
                'expert_id'            => $createdExperts[1]->id,
                'certificate_included' => true,
            ],
            [
                'title'                => 'Product Management Fundamentals',
                'category'             => 'Product & Design',
                'description'          => 'Learn the complete product lifecycle: from user research and ideation to roadmapping, sprint planning, and go-to-market strategy. Ideal for aspiring PMs and startup founders.',
                'duration'             => '2 months',
                'price'                => 490.00,
                'image_url'            => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e',
                'expert_id'            => $createdExperts[2]->id,
                'certificate_included' => true,
            ],
            [
                'title'                => 'Cybersecurity Essentials',
                'category'             => 'Security',
                'description'          => 'Learn to protect systems and networks from cyber threats. Covers ethical hacking, vulnerability assessment, security tools, and compliance. Includes a Capture the Flag challenge.',
                'duration'             => '2 months',
                'price'                => 590.00,
                'image_url'            => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b',
                'expert_id'            => $createdExperts[3]->id,
                'certificate_included' => true,
            ],
            [
                'title'                => 'Data Analysis with Python',
                'category'             => 'Data Science',
                'description'          => 'Master pandas, NumPy, matplotlib, and seaborn to analyse and visualize data. Build dashboards and reports from real business datasets. Beginner-friendly with no prior coding required.',
                'duration'             => '6 weeks',
                'price'                => 350.00,
                'image_url'            => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71',
                'expert_id'            => $createdExperts[0]->id,
                'certificate_included' => false,
            ],
            [
                'title'                => 'Corporate AI Strategy Workshop',
                'category'             => 'Artificial Intelligence',
                'description'          => 'A 3-day intensive workshop designed for business leaders and managers. Learn how to identify AI opportunities, evaluate tools, manage AI projects, and build an AI-ready team.',
                'duration'             => '3 days',
                'price'                => 1200.00,
                'image_url'            => 'https://images.unsplash.com/photo-1531482615713-2afd69097998',
                'expert_id'            => $createdExperts[2]->id,
                'certificate_included' => true,
            ],
        ];

        $createdPrograms = [];
        foreach ($programs as $programData) {
            $createdPrograms[] = Program::create($programData);
        }

        // ── Applications ───────────────────────────────────────────────────────
        $applications = [
            [
                'full_name'  => 'Klajdi Basha',
                'email'      => 'klajdi.basha@gmail.com',
                'phone'      => '+355 69 123 4567',
                'program_id' => $createdPrograms[0]->id,
                'cv_url'     => 'https://drive.google.com/file/d/example1',
                'status'     => 'accepted',
            ],
            [
                'full_name'  => 'Rina Shehu',
                'email'      => 'rina.shehu@outlook.com',
                'phone'      => '+355 67 234 5678',
                'program_id' => $createdPrograms[1]->id,
                'cv_url'     => 'https://drive.google.com/file/d/example2',
                'status'     => 'under_review',
            ],
            [
                'full_name'  => 'Arben Gjoka',
                'email'      => 'a.gjoka@yahoo.com',
                'phone'      => '+355 68 345 6789',
                'program_id' => $createdPrograms[0]->id,
                'cv_url'     => null,
                'status'     => 'new',
            ],
            [
                'full_name'  => 'Dea Prendi',
                'email'      => 'dea.prendi@gmail.com',
                'phone'      => '+355 69 456 7890',
                'program_id' => $createdPrograms[2]->id,
                'cv_url'     => 'https://drive.google.com/file/d/example3',
                'status'     => 'rejected',
            ],
        ];

        foreach ($applications as $applicationData) {
            Application::create($applicationData);
        }

        // ── Employer Requests ──────────────────────────────────────────────────
        $employerRequests = [
            [
                'company_name'   => 'TechAlb Solutions',
                'contact_person' => 'Genti Kola',
                'email'          => 'genti.kola@techalb.al',
                'request_type'   => 'hiring',
                'message'        => 'We are looking to hire 3 junior developers with Laravel and React skills. Can Praktix help us find suitable candidates from your program graduates?',
                'status'         => 'in_progress',
            ],
            [
                'company_name'   => 'Banka Kombetare',
                'contact_person' => 'Alma Zaimi',
                'email'          => 'a.zaimi@bankakombetare.al',
                'request_type'   => 'ai_workshop',
                'message'        => 'We are interested in organizing an AI Strategy Workshop for our senior management team of 20 people. Please contact us to discuss dates and customization options.',
                'status'         => 'pending',
            ],
            [
                'company_name'   => 'Startup Hub Tirana',
                'contact_person' => 'Fjoralba Cela',
                'email'          => 'fjoralba@startuphub.al',
                'request_type'   => 'internship',
                'message'        => 'We would like to offer internship positions to 5 Praktix students in the areas of product and data. Can you share profiles of candidates in their final month?',
                'status'         => 'pending',
            ],
        ];

        foreach ($employerRequests as $requestData) {
            EmployerRequest::create($requestData);
        }
    }
}
