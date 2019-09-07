<?php


namespace nrslib\Cfg\Meta\Settings;


class InterfaceSetting implements BasicSettingInterface
{
    /** @var string */
    private $name;
    /** @var string */
    private $namespace;
    /** @var string[] */
    private $usings = [];

    /**
     * InterfaceSetting constructor.
     * @param $name string
     * @param $namespace string
     */
    public function __construct($name, $namespace)
    {
        if (!preg_match('/\A[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*\Z/', $name)) {
            throw new InvalidArgumentException($name . ' is not a valid PHP interface name, see following https://www.php.net/manual/en/language.oop5.interfaces.php');
        }
        $this->name = $name;
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string[]
     */
    function getUsings(): array
    {
        return $this->usings;
    }

    /**
     * @return bool
     */
    function anyUsing(): bool
    {
        return count($this->usings) > 0;
    }

    /**
     * @param string $module
     * @return InterfaceSetting
     */
    public function addUse(string $module): self
    {
        array_push($this->usings, $module);
        return $this;
    }
}