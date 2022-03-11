<?php

namespace Database\Factories;

use App\Models\Phone;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Phone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => (string)rand(1,9).(string)rand(0,9).(string)rand(0,9).'-'.
            (string)rand(0,9).(string)rand(0,9).(string)rand(0,9).'-'.
            (string)rand(0,9).(string)rand(0,9).(string)rand(0,9).(string)rand(0,9),
            'is_business' => (bool)rand(0,1),
            'contact_id' => Contact::pluck('id')->random()
        ];
    }
}
