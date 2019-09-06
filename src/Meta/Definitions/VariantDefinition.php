<?php


namespace nrslib\Cfg\Meta\Definitions;


/**
 * Class VariantDefinition
 * @package nrslib\Cfg\Meta\Definitions
 */
class VariantDefinition
{

    /** @var string */
    private $name;
    /** @var null|string */
    private $type;

    /**
     * VariantDefinition constructor.
     * @param string $name
     * @param string|null $type
     */
    public function __construct(string $name, string $type = null)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return '$' . $this->name;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function hasType(): bool
    {
        return is_null($this->type);
    }
}