<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserTicker\UserTickerResource;
use App\Models\UserTicker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TickersController extends Controller
{
    public function show()
    {
        $user_tickers = UserTicker::where('user_id', auth()->user()->id)->get();
        $user_tickers = UserTickerResource::collection($user_tickers)->resolve();
        $user_tickers = array_map(fn($el) => $el['ticker'], $user_tickers);

        return Inertia::render('Tickers', compact('user_tickers'));
    }
}
