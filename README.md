# line-notify-sdk

[![pipeline status](https://gitlab.com/chrischuang/line-notify-sdk/badges/master/pipeline.svg)](https://gitlab.com/chrischuang/line-notify-sdk/commits/master)
[![coverage report](https://gitlab.com/chrischuang/line-notify-sdk/badges/master/coverage.svg)](https://gitlab.com/chrischuang/line-notify-sdk/commits/master)

## Introduction

Provide LINE notify oauth & send notify methods

## Documentation

 * LINE Notify API Document: [doc](https://notify-bot.line.me/doc/)
 * LINE Notify My Service Lists: [web](https://notify-bot.line.me/my/services/)

## Requirements
 * PHP 7.2 or later
 * Composer
 
## Installation
 * Add vcs setting to repositories of composer.json
 ```
    {
        "type": "vcs",
        "url": "git@gitlab.com:chrischuang/line-notify-sdk.git"
    },
```

 * Use composer to install line-notify-sdk
```shell script
$ composer require "chrischuang/line-notify-sdk"
```

## Categories

* [OAuth flow](#oauth-flow)
  * [OAuth flow steps](#oauth-flow-steps)
  * [OAuth flow examples](#oauth-flow-examples)
* [Messages](#Messages)
  * [Send notify message examples](#send-notify-message-examples)
* [Apis](#Apis)
  * [Responses](#Responses)
  * [Call api examples](#call-api-examples)


## OAuth flow
 ### OAuth flow steps
   * Get OAuth url and redirect
   * Complete binding flow, redirect to callback url and return `code` & `state` parameters 
   * Verification the transmission is unmodified by `state`
   * Get `access token` of user by `code`
   * Send notify message by access token
   
 ### OAuth flow examples
  * Generate auth url and authorize
```php
// Necessary parameters
$client_id = 'client id of LINE Notify services';
$client_secret = 'client secret of LINE Notify services';
$redirect_uri = 'callback url for accept oauth result';
$state = 'user info of the key uses to verify the correctness of the flow';

// Step1: Generate auth url by state and do authorize action
$auth_url = LINENotify\Auth::create($client_id, $client_secret, $redirect_uri)->genAuthUrl($state);

// Step2: Redirect to auth url and binding user or group, redirect to callback url and return `code` & `state` parameters
```

  * Get access token after callback
```php
// Necessary parameters
$client_id = 'client id of LINE Notify services';
$client_secret = 'client secret of LINE Notify services';
$redirect_uri = 'callback url for accept oauth result';
$state = 'user info of the key uses to verify the correctness of the flow';
$code = 'return by authorize action';

// Step3: Get access token by code
$access_token = LINENotify\Auth::create($client_id, $client_secret, $redirect_uri)->getAccessToken($code);

// Step4: Use access token to send notify messages (see #send-notify-message-examples)
```


## Messages
 * Notify
   * Parameters: `message`
 * Image
   * Parameters: `message`, `imageThumbnail`, `imageFullsize`
 * Sticker
   * Parameters: `message`, `stickerPackageId`, `stickerId`

---

### Send notify message examples
 * Basic message
```php
// Necessary parameters
$access_token = 'access token from oauth';
$message = 'message';

// Create message object
$notify = new LINENotify\Message\Notify();

// Send notify message
$notify->send($access_token, $message);
```

 * Image message
```php
// Necessary parameters
$access_token = 'access token from oauth';
$message = 'message';
$image_url = 'image original url';
$image_thumb_nail_url = 'image thumb nail url'; // if null then setting by image_url

// Create message object
$image = new LINENotify\Message\Image($image_url, $image_thumb_nail_url);

// Send notify message
$image->send($access_token, $message);
```

 * Send sticker message
   * Available sticker list: [pdf](https://drive.google.com/viewerng/viewer?url=https://developers.line.me/media/messaging-api/sticker_list.pdf)
```php
// Necessary parameters
$access_token = 'access token from oauth';
$message = 'message';
$package_id = 'package id of LINE stickers';
$sticker_id = 'sticker id of LINE stickers';

// Create message object
$sticker = new LINENotify\Message\Sticker($package_id, $sticker_id);

// Send notify message
$sticker->send($access_token, $message);
```

## Apis
 * notify: Send messsage by LINE Notify
 * status: Get status of access token
 * revoke: Revoke the access token
 
### Responses
 * ApiResponse: `status`, `message`
   * notify, revoke, api error case
 * StatusResponse: `status`, `message`, `targetType`, `target`
   * status api success case
   
### Call api examples
```php
// Necessary parameters
$access_token = 'access token from oauth';

// Send notify message
$params = ['message' => 'message']; // message content, array format
$response = LINENotify\Api::create($access_token)->notify($params);

// Get status of access token
$response = LINENotify\Api::create($access_token)->status(); // return StatusResponse object

// revoke access token
$response = LINENotify\Api::create($access_token)->revoke();
```
