<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotebookFactory extends Factory
{
    protected $model = \App\Models\Notebook::class;

    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'birth_date' => $this->faker->date(),
            'photo_path' => null, // Можно оставить пустым или добавить путь
        ];
    }
}
