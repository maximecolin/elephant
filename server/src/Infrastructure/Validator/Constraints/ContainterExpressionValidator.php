<?php

namespace App\Infrastructure\Validator\Constraints;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ContainterExpressionValidator extends ConstraintValidator
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * ContainterExpressionValidator constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->expressionLanguage = new ExpressionLanguage();

        $this->expressionLanguage->addFunction(new ExpressionFunction('service', function ($arg) {
            return sprintf('$this->get(%s)', $arg);
        }, function (array $variables, $value) {
            return $variables['container']->get($value);
        }));

        $this->expressionLanguage->addFunction(new ExpressionFunction('parameter', function ($arg) {
            return sprintf('$this->getParameter(%s)', $arg);
        }, function (array $variables, $value) {
            return $variables['container']->getParameter($value);
        }));
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainerExpression) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Expression');
        }

        $variables = array();
        $variables['value'] = $value;
        $variables['this'] = $this->context->getObject();
        $variables['container'] = $this->container;

        if (!$this->expressionLanguage->evaluate($constraint->expression, $variables)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(ContainerExpression::EXPRESSION_FAILED_ERROR)
                ->addViolation();
        }
    }
}
