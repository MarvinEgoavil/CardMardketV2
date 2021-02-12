<?php

use Illuminate\Database\Seeder;

class GameCardSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\Game_card::class, 60)->create();
    }
}
