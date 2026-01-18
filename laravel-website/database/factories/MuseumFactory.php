<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mmo\Faker\FakerImages;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Museum>
 */
class MuseumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        $faker->addProvider(new \Mmo\Faker\LoremSpaceProvider($faker));
        $faker->addProvider(new \Mmo\Faker\FakeimgProvider($faker));

        $museumImageDir = storage_path('app/public/museums');
        $nameImage = $faker->picsum($museumImageDir, 400, 400, false);

        return [
            'nombre' => 'Museo ' . fake()->unique()->company(),
            'ciudad' => fake()->city(),
            'fechas_horarios' => 'Lunes a ' . fake()->randomElement(['Viernes', 'Domingo']) . ': ' . fake()->numberBetween(7, 10) . ':00 - ' . fake()->numberBetween(15, 20) . ':00',
            'visitas_guiadas' => fake()->randomElement(['si', 'no']),
            'precio' => fake()->randomFloat(2, 5, 25),
            'imagen_portada' => 'museums/' . $nameImage,
        ];
    }
}