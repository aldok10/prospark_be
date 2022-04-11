<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => null,
            'name' => $this->faker->name(),
            'description' => $this->faker->text($maxNbChars = 191),
            'price' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
            'stock' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 99999),
        ];
    }
}
