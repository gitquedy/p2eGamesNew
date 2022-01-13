<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;


class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::create([
            'name' => 'Action'
        ]);

        Genre::create([
            'name' => 'Racing'
        ]);

        Genre::create([
            'name' => 'Strategy'
        ]);

        Genre::create([
            'name' => 'Art'
        ]);

        Genre::create([
            'name' => 'Adventure'
        ]);

        Genre::create([
            'name' => 'Sports'
        ]);

        Genre::create([
            'name' => 'Simulation'
        ]);

    }
}
