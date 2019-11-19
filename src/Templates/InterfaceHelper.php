<?php


namespace nrslib\Cfg\Templates;


use nrslib\Cfg\Meta\Settings\InterfaceSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;

class InterfaceHelper
{
    public static function extendsBlock(InterfaceSetting $interfaceSetting)
    {
        if (!$interfaceSetting->hasAnyExtend()) {
            return;
        }

        $extendObjects = implode(', ', $interfaceSetting->getExtends());
        echo ' extends ' . $extendObjects;
    }

    public static function methodBlock(MethodsSetting $methodsSetting)
    {
        if (!$methodsSetting->hasAnyMethod()) {
            return;
        }

        foreach ($methodsSetting->getMethods() as $index => $method) {
            Helper::methodComment($method, 1);
            $returnTypeText = $method->hasReturnType() ? ': ' . $method->getReturnType() : '';
            Helper::el(' public static function ' . $method->getName() . '(' . Helper::methodArguments($method) . ')' . $returnTypeText . ';', 1);
        }
    }
}