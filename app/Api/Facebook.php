<?php

namespace BandManager\App\Api;

use BandManager\ApiUtil\Connector;
use BandManager\ApiUtil\JsonConnector;
use BandManager\ApiUtil\JsonResponse;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Facebook extends Connector
{
    use JsonConnector;

    private const EDGE_ACCESS_TOKEN = 'https://graph.facebook.com/v17.0/oauth/access_token';
    private const EDGE_ME = 'https://graph.facebook.com/v17.0/me'; // huehue

    private readonly string $fbAppId;
    private readonly string $fbAppSecret;
    private readonly string $redirectUri;

    public function __construct()
    {
        parent::__construct();

        $cfg = config();
        $this->fbAppId = $cfg['auth.facebook.id'];
        $this->fbAppSecret = $cfg['auth.facebook.secret'];
        $this->redirectUri = $cfg['app.url'].$cfg['auth.facebook.redirect'];
    }

    public function getAccessToken(string $loginCode, string $redirectUri): JsonResponse
    {
        return $this->getJson(self::EDGE_ACCESS_TOKEN, [
            'query' => [
                'client_id' => $this->fbAppId,
                'client_secret' => $this->fbAppSecret,
                'code' => $loginCode,
                'redirect_uri' => $redirectUri,
            ],
        ]);
    }

    public function getUser(string $accessToken): JsonResponse
    {
        return $this->getJson(self::EDGE_ME, [
            'query' => [
                'fields' => 'id,name',
                'access_token' => $accessToken,
            ],
        ]);
    }

    public function handleAuth(Request $request): array
    {
        $code = $request->query->get('code');

        if (empty($code)) {
            $errMsg = 'Facebook login code not received.';
            Log::warning($errMsg);
            return ['error' => ['message' => $errMsg]];
        }


        $accessTokenResult = $this->getAccessToken($code, $this->redirectUri);
        if ($accessTokenResult->hasException()) {
            return $accessTokenResult->toArray();
        }

        return $this->getUser($accessTokenResult['access_token'])->toArray();
    }
}
