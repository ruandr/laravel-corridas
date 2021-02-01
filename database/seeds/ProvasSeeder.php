<?php

use Illuminate\Database\Seeder;
use App\Models\Prova;

class ProvasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Prova::class, 50)->create();
    }
}
