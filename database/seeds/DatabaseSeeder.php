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
        $this->call(UserSeeder::class);
        $this->call(CorredoresSeeder::class);
        $this->call(ProvasSeeder::class);
        $this->call(ProvasCorredoresSeeder::class);
        $this->call(ProvasResultadosSeeder::class);
    }
}
