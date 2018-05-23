<?php

namespace App\Http\Controllers\Download;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class DownloadComtroller extends Controller
{
    public function index()
    {
        $data = array();
        $disk = Storage::disk('download');
        $files = $disk->allFiles();
        foreach ($files as $key => $file)
        {
            $expires_in = ceil(($disk->size($file)/1024)/500)+60;
            $data[$key] = [
                'filename' => $file,
                'timestamp' => $disk->getTimestamp($file),
                'size' => $disk->size($file),
                'download_url' => $disk->temporaryUrl($file,Carbon::now()->addSeconds($expires_in)),
                'expires_in' => $expires_in ];
        }
        return response()->json($data);
    }
}
