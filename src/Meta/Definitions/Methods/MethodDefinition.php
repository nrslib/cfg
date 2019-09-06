<?php


namespace nrslib\Cfg\Meta\Definitions\Methods;


use nrslib\Cfg\Meta\Definitions\VariantDefinition;
use nrslib\Cfg\Meta\Words\AccessLevel;

/**
 * Class MethodDefinition
 * @package nrslib\Cfg\meta\definitions\methods
 */
class MethodDefinition implements MethodDefinitionInterface
{
    /** @var string */
    private $name;
    /** @var string[] */
    private $body = [];
    /** @var AccessLevel */
    private $accessLevel;
    /** @var VariantDefinition[] */
    private $arguments = [];

    /**
     * MethodDefinition constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->accessLevel = AccessLevel::private();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return AccessLevel
     */
    public function getAccessLevel(): AccessLevel
    {
        return $this->accessLevel;
    }

    /**
     * @return VariantDefinition[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return string[]
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param AccessLevel $level
     * @return MethodDefinition
     */
    public function setAccessLevel(AccessLevel $level): self
    {
        $this->accessLevel = $level;
        return $this;
    }

    /**
     * @param string $name
     * @param string|null $type
     * @return MethodDefinition
     */
    public function addArgument(string $name, string $type = null): self
    {
        array_push($this->arguments, new VariantDefinition($name, $type));
        return $this;
    }

    /**
     * @param string $line
     * @return MethodDefinition
     */
    public function addBody(string $line): self
    {
        array_push($this->body, $line);
        return $this;
    }
}
