<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class score extends Model
{
    use HasFactory;

    protected $fillable = ['x_player_name', 'o_player_name', 'winner_player_name', 'is_a_tie'];
}
