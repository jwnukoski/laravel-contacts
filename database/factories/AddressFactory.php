<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'line_1' => $this->faker->name(),
            'line_2' => $this->faker->name(),
            'city' => $this->faker->name(),
            'state' => $this->faker->name(),
            'zip' => rand(10000,99999),
            'is_business' => (bool)rand(0,1),
            'contact_id' => Contact::pluck('id')->random()
        ];
    }
}
