<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = "sales";

    protected $fillable = [
        'quantity', 'price', 'game_card_id'
    ];
    protected $hidden = [
        'id'
    ];
    public function game_card()
    {
        return $this->belongsTo('App\Models\Game_card');
    }
}
