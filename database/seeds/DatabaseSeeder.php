<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        for($i = 1; $i <= 3; $i++)
        {
            \App\Banner::create([
                'order' => $i,
                'image' => ''
            ]);

        }
    }
}
