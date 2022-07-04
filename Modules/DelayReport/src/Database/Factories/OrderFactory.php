<?php

namespace DelayReport\Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;


class UserFactory extends Factory
{

    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'password' => bcrypt("123456")
        ];
    }
}
