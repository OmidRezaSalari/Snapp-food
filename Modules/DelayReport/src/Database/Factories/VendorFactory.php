<?php

namespace DelayReport\Database\Factories;

use DelayReport\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;


class VendorFactory extends Factory
{

    protected $model = Vendor::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
