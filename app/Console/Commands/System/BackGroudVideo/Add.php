<?php

namespace App\Console\Commands\System\BackGroudVideo;

use App\Models\Settings\BackgroundVideo;
use Illuminate\Console\Command;
use Storage;
use Validator;

class Add extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:bgv:add { url : Background Video URL }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a background video';

    private $support_types = [
        'video/webm',
        'audio/webm',
        'audio/ogg',
        'video/ogg',
        'application/ogg',
        'audio/ogg; codecs=opus',
        'video/mp4',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $validator = Validator::make(['url' => $this->argument('url')],[
            'url' => 'required|url'
        ]);
        if ($validator->passes())
        {
            $html_headers = get_headers($this->argument('url'),1);
            if (array_key_exists('Content-Type',$html_headers))
            {
                if (is_array($html_headers['Content-Type']))
                {
                    foreach ($html_headers['Content-Type'] as $item)
                    {
                        if(in_array($item,$this->support_types))
                        {
                            $html_headers['Content-Type'] = $item;
                            break;
                        }
                    }
                }
                if (is_array($html_headers['Content-Type']))
                {
                    $this->error('Can not get valid media file from that URL.');
                }
                else
                {
                    $content_type = trim($html_headers['Content-Type']);
                    if (in_array($content_type, $this->support_types)) {
                        BackgroundVideo::create([
                            'url' => $this->argument('url'),
                            'mime' => $content_type,
                        ]);
                        $this->info('Media added.');
                    } else {
                        $this->error('Unsupported media type.');
                    }
                }
            }
            else
            {
                $this->error('Can not get valid media file from that URL.');
            }
        }
        else
        {
            if (Storage::disk('minio')->exists('videos/'.$this->argument('url')))
            {
                if (in_array(Storage::disk('minio')->mimeType('videos/'.$this->argument('url')), $this->support_types)) {
                    BackgroundVideo::create([
                        'url' => $this->argument('url'),
                        'mime' => Storage::disk('minio')->mimeType('videos/'.$this->argument('url')),
                    ]);
                    $this->info('Media added.');
                } else {
                    $this->error('Unsupported media type.');
                }
            }
            else
            {
                $this->error('You must supply a valid url or file name of a multi media file.');
            }
        }
    }
}
