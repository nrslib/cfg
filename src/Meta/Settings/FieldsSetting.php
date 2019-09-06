<?php


namespace nrslib\Cfg\Meta\Settings;


use nrslib\Cfg\Meta\Definitions\Fields\FieldDefinition;
use nrslib\Cfg\Meta\Definitions\VariantDefinition;
use nrslib\Cfg\Meta\Words\AccessLevel;

/**
 * Class FieldsSetting
 * @package nrslib\Cfg\Meta\Settings
 */
class FieldsSetting
{

    /**
     * @var FieldDefinition[]
     */
    private $fields = [];

    /**
     * @param string $name
     * @param string $type
     * @param AccessLevel|null $accessLevel
     * @return FieldsSetting
     */
    public function addField(string $name, string $type, AccessLevel $accessLevel = null): self
    {
        array_push(
            $this->fields,
            new FieldDefinition(new VariantDefinition($name, $type), $accessLevel)
        );
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyField()
    {
        return count($this->fields) > 0;
    }

    /**
     * @return FieldDefinition[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}