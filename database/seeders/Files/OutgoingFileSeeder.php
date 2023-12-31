<?php

namespace Database\Seeders\Files;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;


class OutgoingFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x < 1000; $x++)
        {
            DB::table('outgoing_files')->insert($this->getData());
        }

    }

    public function getData()
    {
        return [
            'id' => fake()->uuid(),
            'outgoing_at' => fake()->dateTimeBetween('2020-01-01', date('Y-m-d')),
            'short_description' => fake()->realTextBetween(10, 50),
            'content' => fake()->realTextBetween(1000, 2660),
            'created_at' => now(),
            'path' => fake()->realText(45),
            'author_uuid' => User::inRandomOrder()->first()->id,
            'executor_uuid' => User::inRandomOrder()->first()->id,
        ];
    }
}
