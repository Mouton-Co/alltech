<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
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
        $startTime = $hour.':00:00'; // between 06:00 and 19:00
        $endTime = ($hour + 1).':00:00'; // an hour later

        $contact = $this->faker->randomElement(Contact::all());
        $company = $contact->company;
        $companyType = $company->companyType;

        return [
            'title' => $this->faker->sentence(3),
            'date' => Carbon::now()->format('Y-m-d'), // today
            'location' => $this->faker->address,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'report' => $this->faker->sentence(20),
            'contact_id' => $contact->id,
            'company_id' => $company->id,
            'company_type_id' => $companyType->id,
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
        ];
    }
}
