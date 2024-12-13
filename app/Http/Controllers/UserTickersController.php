<?php

namespace App\Http\Controllers;

use App\Models\UserTicker;
use Illuminate\Http\Request;

class UserTickersController extends Controller
{
    public function toggle(Request $request)
    {
        $data = [
            'user_id' => auth()->user()->id,
            'ticker' => $request->get('ticker')
        ];
        $user_ticker = UserTicker::where($data)->first();

        if ($user_ticker) {
            $user_ticker->delete();
            return json_encode([
                'ticker' => $data['ticker'],
                'status' => 'removed'
            ]);
        }

        UserTicker::create($data);
        return json_encode([
            'ticker' => $data['ticker'],
            'status' => 'added'
        ]);
    }
}
