<?php

declare(strict_types=1);

namespace Capsolver\Solvers\Token;

use Capsolver\Abstracts\TokenAbstract;

class ReCaptchaV2 extends TokenAbstract
{
    public const TASK                       = 'ReCaptchaV2Task';
    public const ENTERPRISE_TASK            = 'ReCaptchaV2EnterpriseTask';
    public const TASK_PROXYLESS             = 'ReCaptchaV2TaskProxyLess';
    public const ENTERPRISE_TASK_PROXYLESS  = 'ReCaptchaV2EnterpriseTaskProxyLess';

    protected const ALLOWED_TYPES = [
        self::TASK,
        self::ENTERPRISE_TASK,
        self::TASK_PROXYLESS,
        self::ENTERPRISE_TASK_PROXYLESS
    ];

    protected const REQUIRED_PARAMS = [
        'type',
        'websiteURL',
        'websiteKey'
    ];
}