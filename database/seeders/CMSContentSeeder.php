<?php

namespace Database\Seeders;

use App\Models\CMSContent;
use Illuminate\Database\Seeder;

class CMSContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Section
        CMSContent::create([
            'section_key' => 'hero',
            'title' => 'Discover the Beauty of Bangladesh',
            'subtitle' => 'Experience authentic adventures with local experts',
            'description' => 'Join us on unforgettable journeys through Bangladesh\'s most stunning landscapes',
            'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4',
            'button_text' => 'Explore Tours',
            'button_link' => '#tours',
            'is_visible' => true,
            'display_order' => 1,
        ]);

        // About Section
        CMSContent::create([
            'section_key' => 'about',
            'title' => 'About Bdeshi Explorer',
            'subtitle' => 'Your Trusted Travel Partner',
            'description' => 'We are passionate about showcasing the hidden gems of Bangladesh. With years of experience and a team of expert guides, we create memorable adventures that combine safety, comfort, and authentic local experiences.',
            'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800',
            'is_visible' => true,
            'display_order' => 2,
            'metadata' => [
                'features' => [
                    ['icon' => 'shield', 'title' => 'Safety First', 'description' => 'Professional guides and safety equipment'],
                    ['icon' => 'users', 'title' => 'Expert Guides', 'description' => 'Local experts with deep knowledge'],
                    ['icon' => 'star', 'title' => 'Best Experience', 'description' => 'Curated itineraries for maximum enjoyment'],
                    ['icon' => 'heart', 'title' => 'Comfort Assured', 'description' => 'Quality accommodations and transport'],
                ]
            ],
        ]);

        // CTA Section
        CMSContent::create([
            'section_key' => 'cta',
            'title' => 'Ready for Your Next Adventure?',
            'subtitle' => 'Book Your Dream Tour Today',
            'description' => 'Don\'t miss out on the opportunity to explore Bangladesh\'s most beautiful destinations with experienced guides.',
            'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470',
            'button_text' => 'Get Started',
            'button_link' => '#tours',
            'is_visible' => true,
            'display_order' => 3,
        ]);

        // Contact Section
        CMSContent::create([
            'section_key' => 'contact',
            'title' => 'Get in Touch',
            'description' => 'Have questions? We\'re here to help you plan your perfect adventure.',
            'is_visible' => true,
            'display_order' => 4,
            'metadata' => [
                'email' => 'info@bdeshi-explorer.com',
                'phone' => '+880 1700-000000',
                'address' => 'Dhaka, Bangladesh',
                'social_media' => [
                    'facebook' => 'https://facebook.com/bdeshi-explorer',
                    'instagram' => 'https://instagram.com/bdeshi-explorer',
                    'twitter' => 'https://twitter.com/bdeshi-explorer',
                ]
            ],
        ]);
    }
}
