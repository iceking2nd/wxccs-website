<?php

namespace App\Models\Fewin;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'fewin_accounts';
    protected $fillable = ['domain_id','steam_account','fewin_account'];
}
