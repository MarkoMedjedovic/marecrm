<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tel = str_replace('-', '', $this->faker->phoneNumber);
        $address = mb_substr($this->faker->address, 9);

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        return [
            'name' => $firstName.' '.$lastName, //$this->faker->name,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'nickname' => "",
            'tel' => $tel,
            'email' => $this->faker->email,
            'postcode' => $this->faker->postcode,
            'address' => $address,
            'birthday' => $this->faker->date,
            'gender' => $this->faker->numberBetween(0, 2),
            'memo' => $this->faker->realText(50),
        ];
    }
}
