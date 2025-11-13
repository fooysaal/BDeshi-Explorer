<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $moderator = User::where('role', 'moderator')->first();

        $tours = [
            [
                'name' => 'Sundarbans Adventure',
                'description' => 'Explore the world\'s largest mangrove forest and spot the Royal Bengal Tiger',
                'location' => 'Sundarbans, Khulna',
                'duration' => '3 Days 2 Nights',
                'price' => 12000,
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1571847636726-4a3c7ecfe3e4',
                'category' => 'Wildlife',
                'hosted_by' => $admin->id,
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(18),
                'total_capacity' => 20,
                'available_capacity' => 20,
                'status' => 'upcoming',
                'is_featured' => true,
                'is_active' => true,
                'safety_terms' => 'Life jackets mandatory, Follow guide instructions, No swimming',
                'highlights' => 'Royal Bengal Tiger spotting, Boat safari, Bird watching, Local cuisine',
                'included' => 'Accommodation, Meals, Guide, Boat rental, Entry fees',
                'excluded' => 'Personal expenses, Tips, Insurance',
            ],
            [
                'name' => 'Cox\'s Bazar Beach Trek',
                'description' => 'Walk along the world\'s longest natural sea beach',
                'location' => 'Cox\'s Bazar',
                'duration' => '2 Days 1 Night',
                'price' => 8000,
                'rating' => 4.6,
                'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19',
                'category' => 'Beach',
                'hosted_by' => $moderator->id,
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(12),
                'total_capacity' => 30,
                'available_capacity' => 30,
                'status' => 'upcoming',
                'is_featured' => true,
                'is_active' => true,
                'safety_terms' => 'Beware of high tides, Stay hydrated, Apply sunscreen',
                'highlights' => 'Sunset viewing, Beach activities, Fresh seafood, Local markets',
                'included' => 'Hotel, Breakfast, Transportation, Guide',
                'excluded' => 'Lunch, Dinner, Activities, Shopping',
            ],
            [
                'name' => 'Sylhet Tea Garden Tour',
                'description' => 'Immerse yourself in the lush green tea gardens of Sylhet',
                'location' => 'Sylhet',
                'duration' => '2 Days 1 Night',
                'price' => 9500,
                'rating' => 4.7,
                'image' => 'https://images.unsplash.com/photo-1563789031959-4c02bcb41319',
                'category' => 'Nature',
                'hosted_by' => $admin->id,
                'start_date' => Carbon::now()->addDays(20),
                'end_date' => Carbon::now()->addDays(22),
                'total_capacity' => 25,
                'available_capacity' => 25,
                'status' => 'upcoming',
                'is_featured' => false,
                'is_active' => true,
                'safety_terms' => 'Wear comfortable shoes, Carry water bottle, Follow plantation rules',
                'highlights' => 'Tea tasting, Jaflong visit, Ratargul swamp forest, Local culture',
                'included' => 'Accommodation, All meals, Transport, Guide, Tea tasting',
                'excluded' => 'Personal shopping, Tips',
            ],
            [
                'name' => 'Bandarban Hill Trekking',
                'description' => 'Trek through the beautiful hills and valleys of Bandarban',
                'location' => 'Bandarban',
                'duration' => '4 Days 3 Nights',
                'price' => 15000,
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306',
                'category' => 'Adventure',
                'hosted_by' => $moderator->id,
                'start_date' => Carbon::now()->addDays(25),
                'end_date' => Carbon::now()->addDays(29),
                'total_capacity' => 15,
                'available_capacity' => 15,
                'status' => 'upcoming',
                'is_featured' => true,
                'is_active' => true,
                'safety_terms' => 'Good physical fitness required, Trekking boots mandatory, Follow guide strictly',
                'highlights' => 'Nilgiri Hills, Tribal villages, Waterfalls, Mountain views',
                'included' => 'Camping equipment, All meals, Guide, Transportation, Permits',
                'excluded' => 'Personal gear, Insurance, Tips',
            ],
            [
                'name' => 'Old Dhaka Heritage Walk',
                'description' => 'Discover the rich history and culture of Old Dhaka',
                'location' => 'Old Dhaka',
                'duration' => '1 Day',
                'price' => 3000,
                'rating' => 4.5,
                'image' => 'https://images.unsplash.com/photo-1585432959305-a4e01dced089',
                'category' => 'Cultural',
                'hosted_by' => $admin->id,
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(5),
                'total_capacity' => 40,
                'available_capacity' => 40,
                'status' => 'upcoming',
                'is_featured' => false,
                'is_active' => true,
                'safety_terms' => 'Stay with group, Keep valuables safe, Comfortable walking shoes',
                'highlights' => 'Lalbagh Fort, Ahsan Manzil, Star Mosque, Street food',
                'included' => 'Guide, Entry fees, Lunch, Transportation',
                'excluded' => 'Personal shopping, Extra snacks',
            ],
            [
                'name' => 'Sajek Valley Exploration',
                'description' => 'Experience the breathtaking beauty of the Queen of Hills',
                'location' => 'Sajek Valley, Rangamati',
                'duration' => '3 Days 2 Nights',
                'price' => 11000,
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4',
                'category' => 'Nature',
                'hosted_by' => $moderator->id,
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(33),
                'total_capacity' => 18,
                'available_capacity' => 18,
                'status' => 'upcoming',
                'is_featured' => true,
                'is_active' => true,
                'safety_terms' => 'Mountain sickness precautions, Warm clothing required, Follow road safety',
                'highlights' => 'Cloud-covered hills, Sunrise viewing, Tribal culture, Helipad views',
                'included' => 'Cottage stay, All meals, 4x4 transport, Guide, Permits',
                'excluded' => 'Extra activities, Shopping, Tips',
            ],
        ];

        foreach ($tours as $tourData) {
            $tourData['slug'] = Str::slug($tourData['name']);
            $tourData['images'] = [
                $tourData['image'],
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800',
                'https://images.unsplash.com/photo-1501785888041-af3ef285b470',
            ];
            $tourData['gallery'] = $tourData['images'];

            Tour::create($tourData);
        }
    }
}
