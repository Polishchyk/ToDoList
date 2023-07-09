<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'title' => Str::random(10),
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            'user_id' => 1,
            'client_id' => 1
        ]);
    }
}
