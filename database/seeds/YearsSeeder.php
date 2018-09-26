<?php

use Illuminate\Database\Seeder;

class YearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('years')->insert([
            'year' => '2018-2019',
        ]);

        DB::table('current_year')->insert([
            'year_id' => 1,
        ]);
    }
}
