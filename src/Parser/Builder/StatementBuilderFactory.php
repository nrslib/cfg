<?php


namespace nrslib\Cfg\Parser\Builder;


use PhpParser\Node\Stmt;
use PhpParser\PrettyPrinter\Standard;

class StatementBuilderFactory
{
    private $standardPrinter;

    /**
     * @param Stmt $stmt
     * @return StatementBuilderInterface
     * @throws \Exception
     */
    public function getBuilder(Stmt $stmt): StatementBuilderInterface
    {
        if ($stmt instanceof Stmt\Expression) {
            return new ExpressionBuilder($this->getStandardPrinter(), $stmt);
        } else if ($stmt instanceof Stmt\Nop) {
            return new NopBuilder($stmt);
        }

        throw new \Exception();
    }

    private function getStandardPrinter()
    {
        if (is_null($this->standardPrinter)) {
            $this->standardPrinter = new Standard();
        }

        return $this->standardPrinter;
    }
}