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

        $response = $this->http_client->post('/oauth/token',[
                'verify' => false,
                'form_params' => $data
        ]);

        $token = json_decode((string)$response->getBody(),true);

        return response()->json([
            'token' => $token['access_token'],
            'auth_id' => md5($token['refresh_token']),
            'expires_in' => $token['expires_in'],
        ])->cookie('refreshToken', $token['refresh_token'], 14400, null, null, false, true);
    }

    public function login($email,$password)
    {
        if (auth()->attempt(['email' => $email , 'password' => $password]))
        {
            return $this->proxy('password',[
                'username' => $email,
                'password' => $password,
                'scope' => ''
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Credentials not match'
            ],421);
        }
    }

    public function refresh()
    {
        $refreshToken = request()->cookie('refreshToken');
        return $this->proxy('refresh_token',[
            'refresh_token' => $refreshToken
        ]);
    }

    public function logout()
    {
        $user = auth()->guard('api')->user();
        if (is_null($user))
        {
            app('cookie')->queue(app('cookie')->forget('refreshToken'));

            return response()->json([
                'message' => 'Logout!'
            ],204);
        }

        $accessToken = $user->token();

        app('db')->table('oauth_refresh_tokens')
            ->where('access_token_id',$accessToken->id)
            ->update([
                'revoked' => true
            ]);

        app('cookie')->queue(app('cookie')->forget('refreshToken'));

        $accessToken->revoke();

        return response()->json([
            'message' => 'Logout!'
        ],204);
    }
}