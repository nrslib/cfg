<?php


namespace nrslib\Cfg\Parser\Builder;


use PhpParser\Node\Stmt\Nop;

class NopBuilder implements StatementBuilderInterface
{
    private $nop;

    public function __construct(Nop $nop)
    {
        $this->nop = $nop;
    }

    function build(): array
    {
        return [];
    }
}