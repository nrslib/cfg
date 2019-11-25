<?php


namespace nrslib\Cfg\Meta\Settings;


use nrslib\Cfg\Meta\Definitions\Methods\MethodDefinition;

/**
 * Class MethodsSetting
 * @package nrslib\Cfg\Meta\Settings
 */
class MethodsSetting
{
    /** @var MethodDefinition[] */
    private $methods = [];

    /**
     * @return MethodDefinition[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param string $name
     * @param callable $predicate MethodDefinition => void
     * @return $this
     */
    public function addMethod(string $name, callable $predicate)
    {
        $definition = new MethodDefinition($name);
        $predicate($definition);
        array_push($this->methods, $definition);
        return $this;
    }

    /**
     * @param string $name
     * @param callable $predicate MethodDefinition => void
     * @return MethodsSetting
     */
    public function updateMethod(string $name, callable $predicate)
    {
        foreach ($this->methods as $method)
        {
            if ($method->getName() === $name)
            {
                $predicate($method);
            }
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyMethod(): bool
    {
        return count($this->methods) > 0;
    }
}