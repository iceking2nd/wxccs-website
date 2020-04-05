<?php

namespace App\Console\Commands\Live\UserAuth;

use App\Models\Live\UserAuth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live:del
        { channel : Live channel }
        { username : Live username }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete live user';

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
     * @throws \Exception
     */
    public function handle()
    {
        $datas = [
            'channel' => $this->argument('channel'),
            'username' => $this->argument('username'),
        ];
        $validator = Validator::make($datas, [
            'channel' => 'required|string',
            'username' => 'required|string',
        ]);
        if ($validator->passes()) {
            if (UserAuth::query()
                ->where('live_channel','=', $datas['live_channel'])
                ->where('live_user','=', $datas['live_user'])
                ->firstOrFail()
                ->delete()) $this->info('User deleted.');
        } else {
            foreach ($validator->errors()->all() as $message)
            {
                $this->error($message);
            }
        }
    }
}
