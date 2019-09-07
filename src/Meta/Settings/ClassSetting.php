<?php


namespace nrslib\Cfg\Meta\Settings;


use nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition;
use InvalidArgumentException;

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
    /** @var string[] */
    private $usings = [];
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
     * @return string[]
     */
    public function getUsings(): array
    {
        return $this->usings;
    }

    /**
     * @return ConstructorDefinition | null
     */
    public function getConstructor(): ?ConstructorDefinition
    {
        return $this->constructor;
    }

    /**
     * @param string $module
     * @return ClassSetting
     */
    public function addUse(string $module): self
    {
        array_push($this->usings, $module);
        return $this;
    }

    /**
     * @return bool
     */
    public function anyUsing(): bool
    {
        return count($this->usings) > 0;
    }

    /**
     * @param string $name
     * @return ClassSetting
     * @throws InvalidArgumentException
     */
    public function setName(string $name): self
    {
        if (!preg_match('/\A[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*\Z/', $name)) {
            throw new InvalidArgumentException($name . ' is not a valid PHP class name, see following https://www.php.net/manual/en/language.oop5.basic.php');
        }

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
