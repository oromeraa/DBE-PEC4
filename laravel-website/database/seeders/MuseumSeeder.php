<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Museum;
use App\Models\Topic;

class MuseumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $museums = Museum::factory(40)->create();

        $museums->each(function ($museum, $index) {
            $topicsIds = range(1, 10);

            if ($index < 20) {
                $topicsQty = rand(2, 4);
            } else {
                $topicsQty = rand(1, 4);
            }

            $topicsToAttach = collect($topicsIds)->shuffle()->take($topicsQty);
            $museum->topics()->attach($topicsToAttach);
        });
    }
}
