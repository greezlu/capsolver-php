<?php

declare(strict_types=1);

namespace Capsolver\Abstracts;

use Capsolver\Exceptions\CapsolverException;

abstract class RecognitionAbstract extends TaskAbstract
{
    /**
     * @param array $request
     * @return array
     *
     * @throws CapsolverException
     */
    protected function process(
        array $request
    ): array {
        $task = $this->createTask($request);

        $solution = $task['solution'] ?? [];

        return is_array($solution) ? $solution : [];
    }
}