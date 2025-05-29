<?php

declare(strict_types=1);

namespace Capsolver\Solvers\Token;

use Capsolver\Abstracts\TokenAbstract;

class Turnstile extends TokenAbstract
{
    public const ANTI_TURNSTILE = 'AntiTurnstileTaskProxyLess';

    protected const REQUIRED_PARAMS = [
        'type',
        'websiteURL',
        'websiteKey'
    ];
}