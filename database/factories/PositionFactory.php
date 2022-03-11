<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\Contact;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Position::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'department_id' => Department::pluck('id')->random(),
            'contact_id' => Contact::pluck('id')->random(),
            'title' => $this->faker->name(),
            'is_liason' => (bool)rand(0,1)
        ];
    }
}
