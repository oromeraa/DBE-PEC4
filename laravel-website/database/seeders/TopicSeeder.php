<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            ['tematica' => 'Pintura'],
            ['tematica' => 'Escultura'],
            ['tematica' => 'Fotografía'],
            ['tematica' => 'Cine'],
            ['tematica' => 'Teatro'],
            ['tematica' => 'Danza'],
        ];

        foreach ($topics as $topic) {
            Topic::create($topic);
        }
    }
}
