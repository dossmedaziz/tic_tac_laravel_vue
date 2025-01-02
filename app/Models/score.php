<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class score extends Model
{
    use HasFactory;

    protected $fillable = ['x_player_name', 'o_player_name', 'winner_player_name', 'is_a_tie'];

    protected $appends =  ['formed_created_at'];

    public function getFormedCreatedAtAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }
}
