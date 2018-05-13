<?php
/**
 * Created by PhpStorm.
 * User: iceki
 * Date: 2018/5/13
 * Time: 17:41
 */

namespace App\Http\Proxy;


use GuzzleHttp\Client;

class TokenProxy
{
    protected $http_client;

    /**
     * TokenProxy constructor.
     * @param $http_client
     */
    public function __construct(Client $http_client)
    {
        $this->http_client = $http_client;
    }

    public function proxy($grantType,array $data=[])
    {
        $data = array_merge($data,[
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'grant_type' => $grantType,
        ]);

        $response = $this->http_client->post('/oauth/token',[
            'verify' => false,
            'http_errors' => false,
            'form_params' => $data
        ]);

        $token = json_decode((string)$response->getBody(),true);

        return response()->json([
            'token' => $token['access_token'],
            'expires_in' => $token['expires_in'],
        ])->cookie('refreshToken', $token['refresh_token'], 864000, null, null, false, true);
    }
}