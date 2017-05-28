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

        \App\Banner::truncate();

        $langs = ['en', 'vi'];

        for($i = 1; $i <= 3; $i++)
        {
            foreach ($langs as $lang) {
                \App\Banner::create([
                    'order' => $i,
                    'image' => '',
                    'language' => $lang
                ]);
            }
        }
    }
}
