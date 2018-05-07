<?php

namespace App\Console\Commands\System\BackGroudVideo;

use App\Models\Settings\BackgroundVideo;
use Illuminate\Console\Command;

class ListBGV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:bgv:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all background videos';

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
        $headers = ['ID','MIME Type','URL'];
        $datas = BackgroundVideo::all(['id','mime','url'])->toArray();
        $this->table($headers,$datas);
    }
}
