<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\TelegramHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\IssueTokenRequest;
use Illuminate\Support\Facades\Auth;

class TelegramAuthController extends Controller
{
    public function issueToken(IssueTokenRequest $request)
    {
        $data = TelegramHelpers::formatInitData($request->data);
        Auth::loginUsingId($data['user']['id']);
        $token = Auth::user()->createToken('telegram', expiresAt: now()->addHours(48));

        return response()->json([
            'token' => $token->plainTextToken,
        ])->cookie('token', $token->plainTextToken, 48 * 60);
    }
}
