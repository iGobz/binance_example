<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserTicker\UserTickerResource;
use App\Models\UserTicker;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show()
    {
        $user_tickers = UserTicker::where('user_id', auth()->user()->id)->get();
        $user_tickers = UserTickerResource::collection($user_tickers)->resolve();
        $user_tickers = array_map(fn($el) => $el['ticker'], $user_tickers);

        return Inertia::render('Dashboard', compact('user_tickers'));
    }
}
