<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hour = $this->faker->numberBetween(6, 19);
        $startTime = $hour . ':00:00'; // between 06:00 and 19:00
        $endTime   = ($hour + 1) . ':00:00'; // an hour later
        
        return [
            'date'                     => Carbon::now()->format('Y-m-d'), // today
            'start_time'               => $startTime,
            'end_time'                 => $endTime,
            'objective'                => $this->faker->sentence,
            'marketing_requirements'   => $this->faker->sentence,
            'added_to_teams'           => false,
            'contact_id'               => $this->faker->randomElement(Contact::pluck('id')->toArray()),
            'company_id'               => $this->faker->randomElement(Company::pluck('id')->toArray()),
            'company_type_id'          => $this->faker->randomElement(CompanyType::pluck('id')->toArray()),
        ];
    }
}
