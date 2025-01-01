<?php

namespace App\Http\Controllers;

use App\Models\score;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function store(Request $request) : JsonResponse
    {
        $data = $request->validate([
            'x_player_name' => 'required|string',
            'o_player_name' => 'required|string',
            'winner_player_name' => 'nullable|string',
            'is_a_tie' => 'required|boolean',
        ]);
        score::create($data);
        return response()->json(['message' => 'Score created successfully'], 201);
    }
}
