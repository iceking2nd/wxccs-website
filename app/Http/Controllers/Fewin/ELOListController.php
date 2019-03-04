<?php

namespace App\Http\Controllers\Fewin;

use App\Models\Fewin\Account;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ParagonIE\ConstantTime\Encoding;
use SteamTotp\SteamTotp;

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
        $accounts = Account::all(['id','domain_id','steam_account','fewin_account','otpauth_uri']);
        $accounts->map(function ($item)
        {
            if (is_null($item['otpauth_uri']))
            {
                $item['otpauth_uri'] = false;
            }
            else
            {
                $query = parse_url($item['otpauth_uri'],PHP_URL_QUERY);
                parse_str($query,$query);
                $item['otpauth_uri'] = isset($query['secret'])?true:false;
            }
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
            'avatar_url' => 'https://oss.5ewin.com/' . $data['user']['avatar_url'],
            'match_total' => $data['data']['match_total'],
            'credit2' => $data['user']['credit2'],
        ];

        error_reporting($env_error_reporting);

        return response()->json($response_data);
    }

    public function getotp($id)
    {
        $otpauth_uri = Account::findOrFail($id)->otpauth_uri;
        $secret_base32 = parse_url($otpauth_uri,PHP_URL_QUERY);
        parse_str($secret_base32,$secret_base32);
        $secret_base32 = $secret_base32['secret'];
        $otp = SteamTotp::getAuthCode(Encoding::base32DecodeUpper($secret_base32),SteamTotp::getTimeOffset());
        return response()->json(["codeimg" => "data:image/png;base64, " . $this->b64img($otp,4,40,20)]);
    }

    public function store(Request $request)
    {
        Account::create($request->all());
        return response()->json(['message' => 'create successful']);
    }

    private function b64img( $str, $fs=10, $w=250, $h=200, $b=array( 'r'=>255, 'g'=>255, 'b'=>255 ), $t=array('r'=>0, 'g'=>0, 'b'=>0) ){
        $tmp=tempnam( sys_get_temp_dir(), 'img' );

        $image = imagecreate( $w, $h );
        $bck = imagecolorallocate( $image, $b['r'], $b['g'], $b['b'] );
        $txt = imagecolorallocate( $image, $t['r'], $t['g'], $t['b'] );

        imagestring( $image, $fs, 0, 0, $str, $txt );
        imagepng( $image, $tmp );
        imagedestroy( $image );

        $data=base64_encode( file_get_contents( $tmp ) );
        @unlink( $tmp );
        return $data;
    }
}
