<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Model;

class UserAuth extends Model
{
    public $table = 'live_auth';
    public $fillable = ['live_channel', 'live_user', 'live_publish_pass', 'live_play_pass'];
}
