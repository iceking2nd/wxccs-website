<?php

namespace App\Http\Controllers\Fewin;

use App\Models\Fewin\Account;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ELOListController extends Controller
{
    private $fe_result=array();

    public function GetAllAccounts(){

        $env_error_reporting = error_reporting();

        error_reporting(0);

        $accounts = Account::all();

        $client = new Client(['verify' => false]);

        $requests = function ($accounts) use ($client)
        {
            foreach ($accounts as $account)
            {
                $uri = 'https://app.5ewin.com/api/data/player/'. $account->domain_id;
                yield function() use ($client,$uri)
                {
                    return $client->getAsync($uri);
                };
            }
        };

        $pool = new Pool($client,$requests($accounts),[
            'concurrency' => 50,
            'fulfilled' => function ($response,$index)
            {
                if ($response->getStatusCode() != 200)
                {
                    \Log::error("[status_code]" .$response->getStatusCode());
                    \Log::error("[response]".$response->getBody()->getContents());
                }
                $res = json_decode($response->getBody()->getContents());
                if(!is_null($res)) $this->fe_result[$res->data->user->domain] = $res->data;
            },
            'rejected' => function ($reason,$index)
            {
                \Log::error($reason->getMessage());
            }
        ]);

        $promise = $pool->promise();
        $promise->wait();

        $accounts->map(function ($item)
        {
            $data = $this->fe_result[$item->domain_id];
            $item['elo'] = $data->data->elo;
            $item['username'] = $data->user->username;
            $item['avatar_url'] = $data->user->avatar_url;
            return $item;
        });

        error_reporting($env_error_reporting);

        return response()->json($accounts);
    }

    public function getAllAccountsDomainIDOnly()
    {
        $accounts = Account::all(['id','domain_id','steam_account','fewin_account']);
        $accounts->map(function ($item)
        {
            $item['elo'] = null;
            $item['username'] = null;
            $item['avatar_url'] = null;
        });
        return response()->json($accounts);
    }

    public function fedataproxy($domain_id)
    {
        $env_error_reporting = error_reporting();

        error_reporting(0);

        $client = new Client(['verify' => false]);

        $response = $client->get('https://app.5ewin.com/api/data/player/'. $domain_id);

        $data = json_decode($response->getBody()->getContents(),true)['data'];

        $response_data = [
            'elo' => $data['data']['elo'],
            'username' => $data['user']['username'],
            'avatar_url' => $data['user']['avatar_url'],
            'match_total' => $data['data']['match_total'],
        ];

        error_reporting($env_error_reporting);

        return response()->json($response_data);
    }

    public function store(Request $request)
    {
        Account::create($request->all());
        return response()->json(['message' => 'create successful']);
    }
}
