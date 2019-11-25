<?php


namespace nrslib\Cfg;


use nrslib\Cfg\Meta\Classes\ClassMeta;

/**
 * Class ClassRenderer
 * @package nrslib\Cfg
 */
class ClassRenderer
{
    /**
     * @param ClassMeta $classMeta
     * @return string
     */
    function render(ClassMeta $classMeta): string
    {
        $class = $classMeta->getClassSetting();
        $fieldsSetting = $classMeta->getFieldsSetting();
        $methodsSetting = $classMeta->getMethodsSetting();
        ob_start();
        include(__DIR__ . '/Templates/ClassTemplate.template.php');
        $data = ob_get_contents();
        ob_end_clean();
        return $data;
    }
}