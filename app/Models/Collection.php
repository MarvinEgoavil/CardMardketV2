<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = "collections";

    protected $fillable = [
        'name', 'symbol', 'edition_date'
    ];

    public function game_cards()
    {
        return $this->belongsToMany('App\Models\Game_card');
    }
}
