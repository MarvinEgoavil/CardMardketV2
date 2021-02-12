<?php

use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\Sale::class, 20)->create();
    }
}
