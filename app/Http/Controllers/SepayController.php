<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SepayController extends Controller
{
    public function webhook(Request $request)
    {
        \Log::info('SePay Webhook:', $request->all());

        return response()->json([
            'success' => true
        ]);
    }
}