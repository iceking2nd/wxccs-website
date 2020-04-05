<?php

namespace App\Console\Commands\Live\UserAuth;

use App\Models\Live\UserAuth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class Set extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live:set 
        { channel : Live Channel }
        { username : Live Username }
        { publish_password : Password for publish mode }
        { play_password : Password for play mode (use publish_password if not set ) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a live user';

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
        $datas = [
            'channel' => $this->argument('channel'),
            'username' => $this->argument('username'),
            'publish_password' => $this->argument('publish_password'),
            'play_password' => $this->argument('play_password')
        ];
        $validator = Validator::make($datas, [
            'channel' => 'required|string',
            'username' => 'required|string',
            'publish_password' => 'required|string',
            'play_password' => 'string'
        ]);
        if ($validator->passes()) {
            $data = [
                'live_channel' => $datas['channel'],
                'live_user' => $datas['username'],
                'live_publish_pass' => $datas['publish_password'],
                'live_play_pass' => !is_null($datas['play_password']) ? $datas['play_password'] : $datas['publish_password']
            ];
            $user = UserAuth::query()
                ->where('live_channel','=', $data['live_channel'])
                ->where('live_user','=', $data['live_user'])
                ->first();
            if ($user->count() == 0) UserAuth::create($data);
            else $user->update($data);
            $this->info('User has been set.');
        } else {
            foreach ($validator->errors()->all() as $message)
            {
                $this->error($message);
            }
        }
    }
}
