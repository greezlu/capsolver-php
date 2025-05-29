<?php

declare(strict_types=1);

namespace Capsolver\Solvers\Token;

use Capsolver\Exceptions\CapsolverException;
use Capsolver\Abstracts\TokenAbstract;

class Turnstile extends TokenAbstract
{
    public const ANTI_TURNSTILE = 'AntiTurnstileTaskProxyLess';

    /**
     * @param array $params
     * @return array
     *
     * @throws CapsolverException
     */
    public function solve(
        array $params
    ): array {
        return $this->process($params);
    }
}