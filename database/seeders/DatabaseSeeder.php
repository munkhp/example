<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('websites')->insert([
            [
                'domain' => 'example1.com',
            ], [
                'domain' => 'example2.com',
            ], [
                'domain' => 'example3.com',
            ]
        ]);
    }
}
