<?php

namespace App\Http\Controllers\Fewin;

use App\Models\Fewin\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ELOListController extends Controller
{
    public function GetAllAccounts()
    {
        $accounts = Account::all(['id','domain_id','steam_account','fewin_account'])->toArray();
        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        Account::create($request->all());
        return response()->json(['message' => 'create successful']);
    }
}
