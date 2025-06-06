# PHP Client for CapSolver API
The simple client for [CapSolver](https://capsolver.com) captcha solving service.

- [Installation](#installation)
    - [Composer](#composer)
- [Configuration](#configuration)
- [Solve captcha](#solve-captcha)
    - [ReCaptcha v3](#recaptcha-v3)
    - [ReCaptcha v2](#recaptcha-v2)
    - [Cloudflare Turnstile](#cloudflare-turnstile)
- [Error handling](#error-handling)

## Installation
This package can be installed via composer.

### Composer
```
composer require greezlu/capsolver-php
```

## Configuration
`CapsolverClient` instance can be created like this:
```php
$solver = new \Capsolver\CapsolverClient('YOUR_API_KEY');
```

## Solve captcha
Find more information about request and response in the related documentation page.

### ReCaptcha v3
More in the [documentation.](https://docs.capsolver.com/en/guide/captcha/ReCaptchaV3/)

Request:
```php
$solution = $solver->recaptchaV3(
    \Capsolver\Solvers\Token\ReCaptchaV3::TASK,
    [
      'websiteURL'    => 'https://www.google.com/recaptcha/api2/demo',
      'websiteKey'    => '6Le-wvkSAAAAAPBMRTvw0Q4Muexq9bi0DJwx_mJ-',
      'pageAction'    => 'verify',
      'minScore'      => 0.6,
      'proxy'         => 'http:ip:port:user:pass'
    ]
);
```

Response:
```php
$solution = [
    'userAgent' => 'xxx',
    'expireTime' => 1671615324290,
    'gRecaptchaResponse' => '3AHJ...'
];
```

### ReCaptcha v2
More in the [documentation.](https://docs.capsolver.com/en/guide/captcha/ReCaptchaV2/)

Request:
```php
$solution = $solver->recaptchaV2(
    \Capsolver\Solvers\Token\ReCaptchaV2::TASK,
    [
      'websiteURL'    => 'https://www.google.com/recaptcha/api2/demo',
      'websiteKey'    => '6Le-wvkSAAAAAPBMRTvw0Q4Muexq9bi0DJwx_mJ-',
      'proxy'         => 'http:ip:port:user:pass'
    ]
);
```

Response:
```php
$solution = [
    'userAgent' => 'xxx',
    'expireTime' => 1671615324290,
    'gRecaptchaResponse' => '3AHJ...'
];
```

### Cloudflare Turnstile
More in the [documentation](https://docs.capsolver.com/en/guide/captcha/cloudflare_turnstile/).

Request:
```php
$solution = $solver->turnsite([
    'websiteURL'    => 'https://www.yourwebsite.com',
    'websiteKey'    => '0x4XXXXXXXXXXXXXXXXX',
    'metadata'      => [
        'action'        => 'login', //optional
        'cdata'         => '0000-1111-2222-3333-example-cdata' //optional
    ]
]);
```

Response:
```php
$result = [
    'token'     => "0.mF74FV8wEuf...",
    'type'      => 'turnstile',
    'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)...'
];
```

## Error handling
If case of an error solver throws an instance of `CapsolverException` exception.

```php
try {
    $solution = $solver->recaptchaV3('', []);
} catch (\Capsolver\Exceptions\RequestException $error) {
    // Error happened before api request
} catch (\Capsolver\Exceptions\ResponseException $error) {
    // Error happened after api request
} catch (\Capsolver\Exceptions\CapsolverException $error) {
    // General error
}
```
