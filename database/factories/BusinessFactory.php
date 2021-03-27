<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->company,
            'address'       => $this->faker->address,
            'phone'         => $this->faker->e164PhoneNumber,
            'category_id'   => rand(1, 12),
            'services'      => [$this->faker->word, $this->faker->word],
            'description'   => $this->faker->paragraph,
            'status_id'     => 3,
            'views_count'   => rand(0, 30),
            'search_count'  => rand(0, 100)
        ];
    }
}
