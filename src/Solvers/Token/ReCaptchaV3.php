<?php

declare(strict_types=1);

namespace Capsolver\Solvers\Token;

use Capsolver\Abstracts\TokenAbstract;

class ReCaptchaV3 extends TokenAbstract
{
    public const TASK                       = 'ReCaptchaV3Task';
    public const ENTERPRISE_TASK            = 'ReCaptchaV3EnterpriseTask';
    public const TASK_PROXYLESS             = 'ReCaptchaV3TaskProxyLess';
    public const ENTERPRISE_TASK_PROXYLESS  = 'ReCaptchaV3EnterpriseTaskProxyLess';

    protected const ALLOWED_TYPES = [
        self::TASK,
        self::ENTERPRISE_TASK,
        self::TASK_PROXYLESS,
        self::ENTERPRISE_TASK_PROXYLESS
    ];

    protected const REQUIRED_PARAMS = [
        'type',
        'websiteURL',
        'websiteKey',
        'pageAction'
    ];
}