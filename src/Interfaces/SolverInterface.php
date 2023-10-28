<?php

declare(strict_types=1);

namespace Capsolver\Interfaces;

use Capsolver\Exceptions\CapsolverException;

interface SolverInterface
{
    /**
     * @param array $request
     * @return array
     *
     * @throws CapsolverException
     */
    public function solve(array $request): array;
}