<?php


namespace nrslib\Cfg\Meta\Definitions\Fields;


use nrslib\Cfg\Meta\Definitions\VariantDefinition;
use nrslib\Cfg\Meta\Words\AccessLevel;

/**
 * Class FieldDefinition
 * @package nrslib\Cfg\Meta\Definitions\Fields
 */
class FieldDefinition
{
    /** @var AccessLevel */
    private $accessLevel;

    /** @var VariantDefinition */
    private $variantDefinition;

    /**
     * FieldDefinition constructor.
     * @param VariantDefinition $variantDefinition
     * @param AccessLevel|null $accessLevel
     */
    public function __construct(VariantDefinition $variantDefinition, AccessLevel $accessLevel = null)
    {
        $this->variantDefinition = $variantDefinition;
        $this->accessLevel = is_null($accessLevel) ? AccessLevel::private() : $accessLevel;
    }

    /**
     * @return AccessLevel
     */
    public function getAccessLevel(): AccessLevel
    {
        return $this->accessLevel;
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return $this->variantDefinition->getName();
    }

    /**
     * @return string
     */
    public function getVariableType(): string
    {
        return $this->variantDefinition->getType();
    }

    /**
     * @return bool
     */
    public function hasType(): bool
    {
        return $this->variantDefinition->hasType();
    }

    /**
     * @param AccessLevel $accessLevel
     * @return FieldDefinition
     */
    public function setAccessLevel(AccessLevel $accessLevel): self
    {
        $this->accessLevel = $accessLevel;
        return $this;
    }
}