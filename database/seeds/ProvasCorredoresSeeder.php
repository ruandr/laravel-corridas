<?php

use Illuminate\Database\Seeder;
use App\Models\ProvaCorredor;
use Illuminate\Support\Facades\DB;

class ProvasCorredoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProvaCorredor::class, 50)->create();
    }
}
