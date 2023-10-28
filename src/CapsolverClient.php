<?php

declare(strict_types=1);

namespace Capsolver;

use Capsolver\Exceptions\CapsolverException;

class CapsolverClient
{
    private string $key;

    /**
     * @param string $key
     */
    public function __construct(
        string $key
    ) {
        $this->key = $key;
    }

    /**
     * @param array $params
     * @return array
     *
     * @throws CapsolverException
     */
    public function recaptchaV3(array $params): array
    {
        $solver = new \Capsolver\Solvers\Token\ReCaptchaV3();
        return $solver->solve($this->hydrate($params));
    }

    /**
     * @param array $params
     * @return array
     */
    private function hydrate(array $params): array
    {
        return [
            'clientKey' => $this->key,
            'task'      => $params
        ];
    }
}