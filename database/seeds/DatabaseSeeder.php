<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(LaratrustSeeder::class);
        // Years Table
        $this->call(YearsSeeder::class);
        // Sports Table
        $this->call(SportsTableSeeder::class);
        // Times Table
        $this->call(TimesSeeder::class);
    }
}
