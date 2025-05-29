<?php

declare(strict_types=1);

namespace Capsolver\Abstracts;

use Capsolver\Exceptions\CapsolverException;

abstract class TaskAbstract extends CommunicatorAbstract
{
    /**
     * @param array $request
     * @return array
     *
     * @throws CapsolverException
     */
    protected function createTask(array $request): array
    {
        return $this->sendRequest(
            'createTask',
            $this->encodeParams($this->hydrateParams($request))
        );
    }

    /**
     * @param array $request
     * @return array
     *
     * @throws CapsolverException
     */
    protected function getTaskResult(array $request): array
    {
        return $this->sendRequest(
            'getTaskResult',
            $this->encodeParams($this->hydrateParams($request, false))
        );
    }

    /**
     * @param array $request
     * @return array
     *
     * @throws CapsolverException
     */
    abstract protected function process(array $request): array;
}
