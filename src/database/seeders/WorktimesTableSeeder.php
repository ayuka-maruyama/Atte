<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Work_time;

class WorktimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Work_time::factory()->count(200)->create();
    }
}
