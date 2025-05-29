<?php

declare(strict_types=1);

namespace Capsolver\Abstracts;

use Capsolver\Exceptions\CapsolverException;
use Capsolver\Exceptions\RequestException;
use Capsolver\Interfaces\SolverInterface;

abstract class TokenAbstract
    extends TaskAbstract
    implements SolverInterface
{
    protected const REQUIRED_PARAMS = [];
    protected const ALLOWED_TYPES = [];

    /**
     * @param array $params
     * @return array
     *
     * @throws CapsolverException
     */
    public function solve(
        array $params
    ): array {
        $this->validateParams($params);
        return $this->process($params);
    }

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

        $taskId = $task['taskId'];

        $queryRequest = 100;

        while ($queryRequest) {
            $taskResult = $this->getTaskResult(['taskId' => $taskId]);

            $taskStatus = $taskResult['status'] ?? null;

            if ($taskStatus !== 'idle' && $taskStatus !== 'processing') {
                break;
            }

            $queryRequest--;

            sleep(1);
        }

        $solution = $taskResult['solution'] ?? [];

        return is_array($solution) ? $solution : [];
    }

    /**
     * @param array $params
     * @return void
     *
     * @throws RequestException
     */
    protected function validateParams(array $params): void
    {
        foreach (static::REQUIRED_PARAMS as $requiredParam) {
            if (!array_key_exists($requiredParam, $params)) {
                throw new RequestException(
                    sprintf(
                        'Missing required request parameter [%s]',
                        $requiredParam
                    )
                );
            }
        }

        $type = $params['type'] ?? '';

        if (
            in_array('type', static::REQUIRED_PARAMS)
            && !empty(static::ALLOWED_TYPES)
            && !in_array($type, static::ALLOWED_TYPES)
        ) {
            throw new RequestException(
                sprintf(
                    'Unrecognized task type [%s]',
                    $type
                )
            );
        }
    }
}