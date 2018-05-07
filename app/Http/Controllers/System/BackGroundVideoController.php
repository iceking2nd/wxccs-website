<?php

namespace App\Http\Controllers\System;

use App\Models\Settings\BackgroundVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Validator;

class BackGroundVideoController extends Controller
{
    public function randomone()
    {
        try
        {
            $background_video = BackgroundVideo::all()->random(1)->first();
        }
        catch (\Exception $e)
        {
            $background_video = new \stdClass();
            $background_video->url = '';
            $background_video->mime = '';
        }
        if ($background_video->url != '')
        {
            $is_url = Validator::make(['url' => $background_video->url],['url' => 'url']);
            if ($is_url->fails())
            {
                $disk = Storage::disk('minio');
                if ($disk->exists('videos/'.$background_video->url)) $background_video->url = $disk->temporaryUrl('videos/'.$background_video->url,now()->addMinutes(5));
            }
        }
        return response()->json(array($background_video),200);
    }
}
