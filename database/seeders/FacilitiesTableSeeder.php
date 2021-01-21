<?php

namespace Database\Seeders;

use App\Models\Facilitie;
use Illuminate\Database\Seeder;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Facilitie::truncate();

        Facilitie::factory()->count(10)->create();
    }
}
