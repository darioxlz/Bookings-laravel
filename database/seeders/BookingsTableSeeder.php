<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Facilitie;
use App\Models\Member;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booking::truncate();

        $facilities = Facilitie::all();
        $members = Member::all();

        Booking::factory()->count(1000)->create()->each(function ($booking) use ($facilities, $members) {
            $booking->update(['facid' => $facilities->random()->facid]);
            $booking->update(['memid' => $members->random()->memid]);
        });
    }
}
