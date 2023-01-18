<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sex = Arr::random(['male', 'female']);
        $class = Classes::inRandomOrder()->first();
            return [
                'firstname' => $this->faker->firstName($sex),
                'surname' => $this->faker->lastName(),
                'sex' => $sex,
                'class_id' => $class->id,
                'studentid' =>  date('ym').Str::padLeft(strval(random_int(0,999999)),6, 0),
            ];
    }
}
