<?php


namespace nrslib\Cfg\Meta\Definitions;

use InvalidArgumentException;

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
     * @throws InvalidArgumentException
     */
    public function __construct(string $name, string $type = null)
    {
        if (!preg_match('/\A[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\Z/', $name)) {
            throw new InvalidArgumentException($name . ' is not a valid PHP variable name, see following https://www.php.net/manual/en/language.variables.basics.php');
        }

        if (!is_null($type) && !preg_match('/\A[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*\Z/', $type)) {
            throw new InvalidArgumentException($type . ' is not a valid PHP type name, see following https://www.php.net/manual/en/language.oop5.basic.php');
        }

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
        return !is_null($this->type);
    }
}
