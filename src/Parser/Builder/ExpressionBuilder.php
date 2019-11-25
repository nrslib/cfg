<?php


namespace nrslib\Cfg\Parser\Builder;


use PhpParser\Node\Stmt\Expression;
use PhpParser\PrettyPrinter\Standard;

class ExpressionBuilder implements StatementBuilderInterface
{
    /**
     * @var Standard
     */
    private $printer;

    /**
     * @var Expression
     */
    private $expression;

    public function __construct($printer, Expression $expression)
    {
        $this->printer = $printer;
        $this->expression = $expression;
    }

    function build(): array
    {
        $printedExpr = $this->printer->prettyPrintExpr($this->expression->expr);

        return array($printedExpr . ';');
    }
}