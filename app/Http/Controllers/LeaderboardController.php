<?php

namespace App\Http\Controllers;

use App\Models\score;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    public function redirectToLeaderboard()
    {

        $searchKey = request()->get('search_key');
        $scores = score::query()
            ->when($searchKey, function ($query, $searchKey) {
                return $query
                    ->where('id', 'like', '%' . $searchKey . '%')
                    ->orWhere('x_player_name', 'like', '%' . $searchKey . '%')
                    ->orWhere('o_player_name', 'like', '%' . $searchKey . '%')
                    ->orWhere('winner_player_name', 'like', '%' . $searchKey . '%');
            })
            ->paginate(10);


        return Inertia::render('Leaderboard', [
            'scores' => $scores,
            'searchKey' => $searchKey,
        ]);
    }
}
