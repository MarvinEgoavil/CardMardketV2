<?php

use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{

    public function run()
    {
        factory(App\Models\Collection::class, 10)->create();
    }
}
