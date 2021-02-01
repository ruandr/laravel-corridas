<?php

use Illuminate\Database\Seeder;
use App\Models\ProvaResultado;

class ProvasResultadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProvaResultado::class, 50)->create();
    }
}
