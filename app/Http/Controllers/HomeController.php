<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{


    public function redirectToBoard()
    {
        return Inertia::render('Home');
    }
}
