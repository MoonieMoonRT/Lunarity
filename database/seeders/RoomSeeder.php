<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $standard = RoomType::where('slug', 'standard')->first();
        $deluxe   = RoomType::where('slug', 'deluxe')->first();
        $suite    = RoomType::where('slug', 'suite')->first();

        // Standard Rooms (10): City 5 | Sea 3 | Pool 2  (ratio ~3:2:1)
        $standardRooms = [
            ['number' => 'N1',  'view' => 'city'],
            ['number' => 'N2',  'view' => 'city'],
            ['number' => 'N3',  'view' => 'city'],
            ['number' => 'N4',  'view' => 'city'],
            ['number' => 'N5',  'view' => 'city'],
            ['number' => 'N6',  'view' => 'sea'],
            ['number' => 'N7',  'view' => 'sea'],
            ['number' => 'N8',  'view' => 'sea'],
            ['number' => 'N9',  'view' => 'pool'],
            ['number' => 'N10', 'view' => 'pool'],
        ];

        // Deluxe Rooms (8): City 4 | Sea 2 | Pool 2  (ratio ~3:2:1)
        $deluxeRooms = [
            ['number' => 'D1', 'view' => 'city'],
            ['number' => 'D2', 'view' => 'city'],
            ['number' => 'D3', 'view' => 'city'],
            ['number' => 'D4', 'view' => 'city'],
            ['number' => 'D5', 'view' => 'sea'],
            ['number' => 'D6', 'view' => 'sea'],
            ['number' => 'D7', 'view' => 'pool'],
            ['number' => 'D8', 'view' => 'pool'],
        ];

        // Suite Rooms (6): City 3 | Sea 2 | Pool 1  (ratio 3:2:1 exact)
        $suiteRooms = [
            ['number' => 'S1', 'view' => 'city'],
            ['number' => 'S2', 'view' => 'city'],
            ['number' => 'S3', 'view' => 'city'],
            ['number' => 'S4', 'view' => 'sea'],
            ['number' => 'S5', 'view' => 'sea'],
            ['number' => 'S6', 'view' => 'pool'],
        ];

        foreach ($standardRooms as $r) {
            Room::create(['room_type_id' => $standard->id, 'room_number' => $r['number'], 'view_type' => $r['view']]);
        }
        foreach ($deluxeRooms as $r) {
            Room::create(['room_type_id' => $deluxe->id, 'room_number' => $r['number'], 'view_type' => $r['view']]);
        }
        foreach ($suiteRooms as $r) {
            Room::create(['room_type_id' => $suite->id, 'room_number' => $r['number'], 'view_type' => $r['view']]);
        }
    }
}
