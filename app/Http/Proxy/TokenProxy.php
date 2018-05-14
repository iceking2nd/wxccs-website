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
    public function __construct()
    {
        $this->http_client = new Client(['base_uri' => \Request::getSchemeAndHttpHost()]);
    }

    public function proxy($grantType,array $data=[])
    {
        $data = array_merge($data,[
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'grant_type' => $grantType,
        ]);

        try
        {
            $response = $this->http_client->post('/oauth/token',[
                'form_params' => $data
            ]);
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
        }

        $token = json_decode((string)$response->getBody(),true);

        return response()->json([
            'token' => $token['access_token'],
            'expires_in' => $token['expires_in'],
        ])->cookie('refreshToken', $token['refresh_token'], 864000, null, null, false, true);
    }

    public function login($email,$password)
    {
        return $this->proxy('password',[
            'username' => $email,
            'password' => $password,
            'scope' => ''
        ]);
    }
}