<?php


namespace nrslib\Cfg\Meta\Settings;


use nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition;

/**
 * Class ClassSetting
 * @package nrslib\Cfg\Meta\Settings
 */
class ClassSetting
{
    /** @var string */
    private $namespace;
    /** @var string */
    private $name;
    /** @var ConstructorDefinition */
    private $constructor;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return ConstructorDefinition | null
     */
    public function getConstructor(): ?ConstructorDefinition
    {
        return $this->constructor;
    }

    /**
     * @param string $name
     * @return ClassSetting
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $namespace
     * @return ClassSetting
     */
    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @param $predicate
     * @return ClassSetting
     */
    public function setConstructor($predicate): self
    {
        $constructor = new ConstructorDefinition();
        $predicate($constructor);
        $this->constructor = $constructor;
        return $this;
    }
}