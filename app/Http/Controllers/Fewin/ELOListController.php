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

    public function GetAllAccounts()
    {
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
                $res = json_decode($response->getBody()->getContents(),true);
                if(!is_null($res))
                {
                    $res['data']['static'] = $res['data']['data'];
                    unset($res['data']['data']);
                    $this->fe_result[$res['data']['user']['domain']] = $res['data'];
                }
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
            $item['username'] = $this->fe_result[$item->domain_id]['user']['username'];
            $item['avatar_url'] = $this->fe_result[$item->domain_id]['user']['avatar_url'];
            $item['elo'] = $this->fe_result[$item->domain_id]['static']['elo'];
            return $item;
        });

        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        Account::create($request->all());
        return response()->json(['message' => 'create successful']);
    }
}
