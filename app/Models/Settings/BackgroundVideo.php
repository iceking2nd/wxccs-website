<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class BackgroundVideo extends Model
{
    protected $table = 'settings_background_video';
    protected $fillable = ['url','mime'];
}
