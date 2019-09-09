<?php


namespace nrslib\Cfg\Meta\Definitions\Methods;


use nrslib\Cfg\Meta\Definitions\VariantDefinition;
use nrslib\Cfg\Meta\Words\AccessLevel;
use InvalidArgumentException;

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
    /** @var null|string */
    private $returnType = null;

    /**
     * MethodDefinition constructor.
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function __construct(string $name)
    {
        if (!preg_match('/\A[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*\Z/', $name)) {
            throw new InvalidArgumentException($name . ' is not a valid PHP method name, see following https://www.php.net/manual/en/functions.user-defined.php');
        }

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
     * @return null|string
     */
    public function getReturnType(): ?string
    {
        return $this->returnType;
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
     * @param bool $ignoreVoid true && $returnType === 'void' -> false
     * @return bool
     */
    public function hasReturnType(bool $ignoreVoid = false): bool
    {
        if ($ignoreVoid && $this->returnType === 'void') {
            return false;
        }
        return !is_null($this->returnType);
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
     * @param string $type
     * @return MethodDefinition
     */
    public function setReturnType(string $type): self
    {
        $this->returnType = $type;
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
