<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_statuses')->insert(array(
            [
                'title' => 'To do',
                'position' => 1,
            ],
            [
                'title' => 'On hold',
                'position' => 2,
            ],
            [
                'title' => 'In progress',
                'position' => 3,
            ],
            [
                'title' => 'Ready for QA',
                'position' => 4,
            ],
            [
                'title' => 'QA',
                'position' => 5,
            ],
            [
                'title' => 'Done',
                'position' => 6,
            ],
        ));
    }
}
