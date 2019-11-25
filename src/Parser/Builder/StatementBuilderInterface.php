<?php


namespace nrslib\Cfg\Parser\Builder;


interface StatementBuilderInterface
{
    /**
     * @return string[]
     */
    function build(): array;
}