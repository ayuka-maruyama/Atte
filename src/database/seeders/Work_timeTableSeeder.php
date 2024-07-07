<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Work_time;

class Work_timeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Work_time::factory()
            ->count(500)
            ->withBreaks()
            ->create();
    }
}
