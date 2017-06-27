<?php

namespace App\Infrastructure\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Expression;

class ContainerExpression extends Expression
{
    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'validator.container_expression';
    }
}
