<?php

namespace App\Http\Controllers\Live;

use App\Models\Live\UserAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $this->validate($request, [
            'channel' => 'required',
            'mode' => ['required', Rule::in(['publish', 'play'])],
            'psk' => 'required'
        ]);
        $user = UserAuth::query();
        $user->where('live_channel', '=', $request->get('channel'));
        $user->where($request->get('channel') == 'publish' ? 'live_publish_pass' : 'live_play_pass', '=', $request->get('psk'));
        if ($user->get()->count() == 1) return response()->make('', 201);
        return response()->make('', 403);
    }
}
