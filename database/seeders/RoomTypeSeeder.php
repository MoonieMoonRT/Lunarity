<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        RoomType::create([
            'name'              => 'Standard Room',
            'slug'              => 'standard',
            'short_description' => 'A comfortable and elegantly designed room with all essential amenities for a relaxing stay.',
            'description'       => 'Our Standard Room offers a serene retreat with plush bedding, a work desk, flat-screen TV, and a private en-suite bathroom with rainfall shower. Thoughtfully designed to blend comfort with elegance, it\'s the perfect base for both business and leisure travelers. Room size: 28 sqm.',
            'price_per_night'   => 850000,
            'max_capacity'      => 2,
            'image_url'         => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80',
        ]);

        RoomType::create([
            'name'              => 'Deluxe Room',
            'slug'              => 'deluxe',
            'short_description' => 'Elevated luxury with premium furnishings, superior views, and exclusive in-room amenities.',
            'description'       => 'Step into refined luxury with our Deluxe Room, featuring premium furnishings, a king-size bed with premium linens, a separate soaking tub, and a panoramic city or sea view. Includes complimentary minibar, Nespresso machine, and dedicated concierge service. Room size: 42 sqm.',
            'price_per_night'   => 1500000,
            'max_capacity'      => 2,
            'image_url'         => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80',
        ]);

        RoomType::create([
            'name'              => 'Suite Room',
            'slug'              => 'suite',
            'short_description' => 'The pinnacle of luxury — a spacious suite with a private living area and bespoke butler service.',
            'description'       => 'Experience the ultimate in luxury with our Suite Room — a lavish sanctuary featuring a separate living room, walk-in closet, premium Jacuzzi, and a private balcony with breathtaking views. Enjoy bespoke butler service, curated welcome amenities, and exclusive lounge access. Room size: 75 sqm.',
            'price_per_night'   => 3200000,
            'max_capacity'      => 3,
            'image_url'         => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80',
        ]);
    }
}
