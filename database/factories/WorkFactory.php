<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->unique->word(20);
        return [
            'name' => $name,
            'status' => $this->faker->randomElement([Work::NoRealizado,Work::Realizado]),
            'user_id'=>User::all()->random()->id,
            
            
        ];
    }
}
