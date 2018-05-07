<?php

namespace App\Console\Commands\System\BackGroudVideo;

use App\Models\Settings\BackgroundVideo;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:bgv:del { id : Background Video ID ( Get by system:bgv:list ) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a background video';

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
        try
        {
            BackgroundVideo::findOrFail($this->argument('id'))->delete();
        }
        catch (Exception $e)
        {
            if($e instanceof ModelNotFoundException)
            {
                $this->error('Media not found.');
            }
            else
            {
                $this->error($e->getMessage());
            }
        }
    }
}
