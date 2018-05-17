<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function update()
    {
        request()->user()->update(request()->only('name','email'));

        return response()->json(['status' => true]);
    }
}
