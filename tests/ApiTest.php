<?php

namespace Tests\LINENotify;

use LINENotify\Api;
use LINENotify\Message\Image;
use LINENotify\Message\Notify;
use LINENotify\Message\Sticker;
use LINENotify\Response\StatusResponse;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ApiTest extends TestCase
{
    protected function mockRequest(bool $success = true)
    {
        $body = ($success) ?
            ['status' => 200, 'message' => 'Success',] :
            ['status' => 401, 'message' => 'Invalid access token',];

        $this->mockClient(json_encode($body));
    }

    public function testRevoke()
    {
        $this->mockRequest();
        $this->assertTrue(Api::create('test')->revoke());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid access token
     */
    public function testRevokeException()
    {
        $this->mockRequest(false);
        Api::create('test')->revoke();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid access token');
    }

    public function testNotify()
    {
        $this->mockRequest();
        $this->assertTrue(Api::create('test')->notify(['message' => 'test']));
    }

    public function sendNotifyProvider()
    {
        return [
            [new Notify()],
            [new Image('test')],
            [new Sticker(11537, 52002734)],
        ];
    }

    /**
     * @dataProvider sendNotifyProvider
     * @param $notify
     */
    public function testSendNotify(Notify $notify)
    {
        $this->mockRequest();
        $this->assertTrue($notify->send('access token', 'message'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid access token
     */
    public function testNotifyException()
    {
        $this->mockRequest(false);
        Api::create('test')->notify(['message' => 'test']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid access token');
    }

    public function testStatus()
    {
        $body = json_encode([
            'status' => 200,
            'message' => 'success',
            'targetType' => 'GROUP',
            'target' => 'group name',
        ]);
        $this->mockClient($body);

        $expected = StatusResponse::init($body);

        $this->assertEquals($expected, Api::create('test')->status());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid access token
     */
    public function testStatusException()
    {
        $this->mockRequest(false);

        Api::create('test')->status();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid access token');
    }
}
