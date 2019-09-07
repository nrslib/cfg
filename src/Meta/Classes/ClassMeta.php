<?php


namespace nrslib\Cfg\Meta\Classes;


use nrslib\Cfg\Meta\Settings\ClassSetting;
use nrslib\Cfg\Meta\Settings\FieldsSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;

/**
 * Class ClassMeta
 * @package nrslib\Cfg\Meta\Classes
 */
class ClassMeta
{
    /** @var ClassSetting */
    private $classSetting;
    /** @var FieldsSetting */
    private $fieldsSetting;
    /** @var MethodsSetting */
    private $methodSetting;

    /**
     * ClassMeta constructor.
     * @param string $name
     * @param string $namespace
     */
    public function __construct(string $name, string $namespace)
    {
        $this->classSetting = new ClassSetting($name, $namespace);
        $this->fieldsSetting = new FieldsSetting();
        $this->methodSetting = new MethodsSetting();
    }

    /**
     * @return ClassSetting
     */
    public function getClassSetting(): ClassSetting
    {
        return $this->classSetting;
    }

    /**
     * @return MethodsSetting
     */
    public function getMethodsSetting(): MethodsSetting
    {
        return $this->methodSetting;
    }

    /**
     * @return FieldsSetting
     */
    public function getFieldsSetting(): FieldsSetting
    {
        return $this->fieldsSetting;
    }

    /**
     * @return ClassSetting
     */
    public function setupClass(): ClassSetting
    {
        return $this->classSetting;
    }

    /**
     * @return MethodsSetting
     */
    public function setupMethods(): MethodsSetting
    {
        return $this->methodSetting;
    }

    /**
     * @return FieldsSetting
     */
    public function setupFields(): FieldsSetting
    {
        return $this->fieldsSetting;
    }
}
