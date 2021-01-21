<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::truncate();

        Member::factory()->count(31)->create();

        $members = Member::all();

        $members->each(function ($member) use ($members) {
            switch (rand(0, 2)) {
                case 0:
                    $member->update(['recommendedby' => null]);
                    break;

                default:
                    $member->update(['recommendedby' => $members->random()->memid]);
                    break;
            }
        });
    }
}
