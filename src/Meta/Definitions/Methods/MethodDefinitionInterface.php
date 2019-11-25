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
    function getComments(): array;

    /**
     * @return string[]
     */
    function getBody(): array;

    /**
     * @return null|string
     */
    function getReturnType(): ?string;

    /**
     * @param bool $ignoreVoid
     * @return bool
     */
    function hasReturnType(bool $ignoreVoid): bool;
}
