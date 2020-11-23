<?php

namespace Tests\LINENotify;

use LINENotify\Auth;

class AuthTest extends TestCase
{
    protected $auth;
    public function setUp()
    {
        $this->auth = Auth::create('test', 'test', 'https://test.com');
    }

    public function testGenAuthUrl()
    {
        $params = [
            "response_type" => "code",
            "client_id" => 'test',
            "redirect_uri" => 'https://test.com',
            "scope" => "notify",
            "state" => 'test',
            "response_mode" => "form_post",
        ];
        $expected = Auth::OAUTH_URL . '/authorize?' . http_build_query($params);
        $this->assertEquals($expected, $this->auth->genAuthUrl('test', true));
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testGetAccessToken()
    {
        $this->mockClient(json_encode(['access_token' => 'test']));
        $this->assertEquals('test', $this->auth->getAccessToken('test'));
    }
}