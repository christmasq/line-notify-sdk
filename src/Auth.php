<?php


namespace LINENotify;


use GuzzleHttp\Client;

class Auth
{
    const OAUTH_URL = 'https://notify-bot.line.me/oauth';

    /**
     * @var string
     */
    protected $client_id;
    /**
     * @var string
     */
    protected $client_secret;
    /**
     * @var string
     */
    protected $redirect_uri;

    /**
     * Notify constructor.
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     */
    public function __construct(string $client_id, string $client_secret, string $redirect_uri)
    {
        $this->setAuthConfig($client_id, $client_secret);
        $this->setRedirectUri($redirect_uri);
    }

    /**
     * Create Auth object
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     * @return Auth
     */
    public static function create(string $client_id, string $client_secret, string $redirect_uri): Auth
    {
        return new static($client_id, $client_secret, $redirect_uri);
    }

    /**
     * Set auth config
     * @param string $client_id
     * @param string $client_secret
     * @return $this
     */
    public function setAuthConfig(string $client_id, string $client_secret): self
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        return $this;
    }

    /**
     * Set redirect uri
     * @param string $redirect_uri callback url
     * @return $this
     */
    public function setRedirectUri(string $redirect_uri): self
    {
        $this->redirect_uri = $redirect_uri;
        return $this;
    }

    /**
     * Generate auth url for oauth flow
     * @param string $state
     * @return string
     */
    public function genAuthUrl(string $state): string
    {
        $params = [
            "response_type" => "code",
            "client_id" => $this->client_id,
            "redirect_uri" => $this->redirect_uri,
            "scope" => "notify",
            "state" => $state,
        ];
        return static::OAUTH_URL . '/authorize?' . http_build_query($params);
    }

    /**
     * Get access token by client code from oauth authorize response
     * @param string $code the client code from oauth authorize response
     * @return string
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccessToken(string $code): string
    {
        $params = [
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => $this->redirect_uri,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
        ];
        $client = new Client();
        $response = $client->request('POST', static::OAUTH_URL . '/token', ['form_params' => $params]);
        $res = json_decode($response->getBody());
        return $res->access_token;
    }
}