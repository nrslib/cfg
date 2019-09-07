<?php


namespace nrslib\Cfg\Meta\Settings;


use nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition;
use InvalidArgumentException;

/**
 * Class ClassSetting
 * @package nrslib\Cfg\Meta\Settings
 */
class ClassSetting implements BasicSettingInterface
{
    /** @var string */
    private $namespace;
    /** @var string */
    private $name;
    /** @var string[] */
    private $usings = [];
    /** @var null|string */
    private $extend = null;
    /** @var string[] */
    private $implements = [];
    /** @var ConstructorDefinition */
    private $constructor;

    /**
     * ClassSetting constructor.
     * @param string $name
     * @param string $namespace
     */
    public function __construct(string $name, string $namespace)
    {
        if (!preg_match('/\A[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*\Z/', $name)) {
            throw new InvalidArgumentException($name . ' is not a valid PHP class name, see following https://www.php.net/manual/en/language.oop5.basic.php');
        }
        $this->name = $name;
        $this->namespace = $namespace;
    }

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
     * @return null|string
     */
    public function getExtend(): ?string
    {
        return $this->extend;
    }

    /**
     * @return string[]
     */
    public function getImplements(): array
    {
        return $this->implements;
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
     * @param callable ConstructorDefinition => void
     * @return ClassSetting
     */
    public function setConstructor($predicate): self
    {
        $constructor = new ConstructorDefinition();
        $predicate($constructor);
        $this->constructor = $constructor;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasExtend(): bool
    {
        return !is_null($this->extend);
    }

    /**
     * @param string $extend
     * @return ClassSetting
     */
    public function setExtend(string $extend): self
    {
        $this->extend = $extend;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyImplements(): bool
    {
        return count($this->implements) > 0;
    }

    /**
     * @param string $implement
     * @return ClassSetting
     */
    public function addImplement(string $implement): self
    {
        array_push($this->implements, $implement);
        return $this;
    }
}
