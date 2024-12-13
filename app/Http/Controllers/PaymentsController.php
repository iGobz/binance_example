<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payments\StoreRequest;
use App\Http\Resources\Payments\PaymentsResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Payment;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', auth()->user()->id)
                    ->orderBy('desc')
                    ->get();
        $payments = PaymentsResource::collection($payments)->resolve();

        return Inertia::render('Payments', compact('payments'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $payment = Payment::create($data);
        $payment = PaymentsResource::make($payment)->resolve();
        return json_encode($payment);

    }
}
