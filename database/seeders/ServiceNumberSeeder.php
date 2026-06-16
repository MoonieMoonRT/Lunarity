<?php

namespace Database\Seeders;

use App\Models\ServiceNumber;
use Illuminate\Database\Seeder;

class ServiceNumberSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['extension' => '1',   'department' => 'Front Desk',       'description' => 'Check-in, check-out, and general inquiries'],
            ['extension' => '2',   'department' => 'Restaurant',        'description' => 'Reservations, room service, and dining'],
            ['extension' => '3',   'department' => 'Customer Service',  'description' => 'Complaints, feedback, and special requests'],
            ['extension' => '4',   'department' => 'Housekeeping',      'description' => 'Room cleaning, extra towels, and laundry'],
            ['extension' => '5',   'department' => 'Security',          'description' => '24/7 security and emergency assistance'],
            ['extension' => '6',   'department' => 'Concierge',         'description' => 'Transportation, tickets, and local recommendations'],
            ['extension' => '7',   'department' => 'Spa & Wellness',    'description' => 'Appointments, treatments, and wellness packages'],
            ['extension' => '8',   'department' => 'Business Center',   'description' => 'Printing, meetings, and corporate services'],
            ['extension' => '9',   'department' => 'Pool & Recreation', 'description' => 'Pool hours, gym access, and activity bookings'],
            ['extension' => '10',  'department' => 'Maintenance',       'description' => 'Technical issues, repairs, and utilities'],
            [
                'extension'      => '666',
                'department'     => '???',
                'description'    => 'Do not call this number...',
                'is_easter_egg'  => true,
                'easter_egg_url' => 'https://www.youtube.com/watch?v=6VMRAGxjOoA&pp=ygUDNjY2',
            ],
        ];

        foreach ($services as $service) {
            ServiceNumber::create($service);
        }
    }
}
