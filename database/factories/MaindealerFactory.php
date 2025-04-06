<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maindealer>
 */
class MaindealerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kodemd' => strtoupper($this->faker->bothify('MD###')),
            'nama_md' => $this->faker->company,
        ];
    }
}
