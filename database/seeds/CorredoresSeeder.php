<?php

use Illuminate\Database\Seeder;
use App\Models\Corredor;

class CorredoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Corredor::class, 30)->create();
    }
}
