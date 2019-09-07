<?php


namespace nrslib\Cfg\Meta\Interfaces;


use nrslib\Cfg\Meta\Settings\InterfaceSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;

class InterfaceMeta
{
    /** @var InterfaceSetting */
    private $interfaceSetting;
    /** @var MethodsSetting */
    private $methodsSetting;

    public function __construct(string $name, string $namespace)
    {
        $this->interfaceSetting = new InterfaceSetting($name, $namespace);
        $this->methodsSetting = new MethodsSetting();
    }

    /**
     * @return InterfaceSetting
     */
    public function getInterfaceSetting(): InterfaceSetting
    {
        return $this->interfaceSetting;
    }

    /**
     * @return MethodsSetting
     */
    public function getMethodsSetting(): MethodsSetting
    {
        return $this->methodsSetting;
    }
}