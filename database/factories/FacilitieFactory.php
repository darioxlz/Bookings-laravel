<?php

namespace Database\Factories;

use App\Models\Facilitie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacilitieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Facilitie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();

        return [
            'name' => $this->faker->words(3, true),
            'membercost' => $this->faker->randomFloat(2, 0, 35),
            'guestcost' => $this->faker->randomFloat(2, 0, 80),
            'initialoutlay' => $this->faker->numberBetween(320, 100000),
            'monthlymaintenance' => $this->faker->numberBetween(15, 3000),
            'createdby' => $users->random()->userid
        ];
    }
}
