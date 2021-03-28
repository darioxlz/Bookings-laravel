<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();

        return [
            'surname' => $this->faker->firstName,
            'firstname' => $this->faker->lastName,
            'address' => $this->faker->address,
            'zipcode' => $this->faker->randomNumber(4),
            'telephone' => $this->faker->phoneNumber,
            'joindate' => $this->faker->dateTimeBetween('2012-07-01', '2012-09-26')
        ];
    }
}
