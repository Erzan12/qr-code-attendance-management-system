<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class QrCodeController extends Controller
{
    public function myQrCode(Request $request)
    {
        $user = $request->user();

        $payload = $user->account_type === \App\Models\User::STUDENT
            ? $user->user_id.'-2'
            : $user->user_id.'-3';

        return response()->json([
            'qr_code' => Crypt::encryptString($payload),
        ]);
    }
}
