<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game_card extends Model
{
    protected $table = "game_cards";

    protected $fillable = [
        'id', 'name', 'description', 'user_id'
    ];

    protected function users()
    {
        return $this->belongsTo('App\User');
    }

    protected function sales()
    {
        return $this->hasMany('App\Models\Sale');
    }

    protected function collections()
    {
        return $this->belongsToMany('App\Models\Collection');
    }
}
