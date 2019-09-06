<?php


namespace nrslib\Cfg\Meta\Definitions\Methods;


use nrslib\Cfg\Meta\Definitions\VariantDefinition;

/**
 * Interface MethodDefinitionInterface
 * @package nrslib\Cfg\meta\definitions\methods
 */
interface MethodDefinitionInterface
{
    /**
     * @return VariantDefinition[]
     */
    function getArguments(): array;

    /**
     * @return string[]
     */
    function getBody(): array;
}