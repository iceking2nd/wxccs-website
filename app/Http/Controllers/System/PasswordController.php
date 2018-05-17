<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    public function update()
    {
        request()->user()->update(['password' => bcrypt(request('password'))]);
        return response()->json(['status' => true]);
    }
}
