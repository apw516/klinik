<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        $menu = 'dashboard';
        $menu_sub = 'dashboard';
        return view('Dashboard.index', compact([
            'menu',
            'menu_sub'
        ]));
    }
}
