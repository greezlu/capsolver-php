<?php

declare(strict_types=1);

namespace Capsolver\Solvers;

use Capsolver\Abstracts\CommunicatorAbstract;
use Capsolver\Exceptions\CapsolverException;

class CapsolverBalance extends CommunicatorAbstract
{
    /**
     * @return array
     *
     * @throws CapsolverException
     */
    public function getBalance(): array
    {
        return $this->sendRequest(
            'getBalance',
            $this->encodeParams($this->hydrateParams([], false))
        );
    }
}
