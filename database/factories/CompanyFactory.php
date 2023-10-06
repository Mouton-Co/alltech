<?php

namespace Database\Factories;

use App\Models\CompanyType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'            => $this->faker->company,
            'location'        => $this->faker->country,
            'coordinates'     => $this->faker->latitude . ' ' . $this->faker->longitude,
            'company_type_id' => $this->faker->randomElement(CompanyType::pluck('id')->toArray()),
        ];
    }
}
