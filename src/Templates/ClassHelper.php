<?php


namespace nrslib\Cfg\Templates;


use nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition;
use nrslib\Cfg\Meta\Settings\ClassSetting;
use nrslib\Cfg\Meta\Settings\FieldsSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;

class ClassHelper
{
    public static function extendsBlock(ClassSetting $classSetting)
    {
        if (!$classSetting->hasExtend()) {
            return;
        }

        echo ' extends ' . $classSetting->getExtend();
    }

    public static function implementsBlock(ClassSetting $classSetting)
    {
        if (!$classSetting->hasAnyImplements()) {
            return;
        }

        $implementObjects = implode(', ', $classSetting->getImplements());
        echo ' implements ' . $implementObjects;
    }

    public static function fieldBlock(FieldsSetting $fieldsSetting)
    {
        if (!$fieldsSetting->hasAnyField()) {
            return;
        }

        foreach ($fieldsSetting->getFields() as $index => $field) {
            Helper::fieldComment($field, 1);
            Helper::el($field->getAccessLevel()->toText() . ' ' . $field->getVariableName() . ';', 1);
        }

        Helper::el();
    }

    public static function constructorBlock(ClassSetting $classSetting, ?ConstructorDefinition $constructorDefinition)
    {
        if (is_null($constructorDefinition)) {
            return;
        }

        Helper::methodComment($constructorDefinition, 1, $classSetting->getName() . ' constructor.');
        Helper::el(\nrslib\Cfg\Meta\Words\AccessLevel::public()->toText() . ' public static function __construct(' . Helper::methodArguments($constructorDefinition) . ')', 1);
        Helper::el('{', 1);
        Helper::echoMethodBody($constructorDefinition, 2);
        Helper::el('}', 1);
        Helper::el();
    }

    public static function methodBlock(MethodsSetting $methodsSetting)
    {
        if (!$methodsSetting->hasAnyMethod()) {
            return;
        }

        foreach ($methodsSetting->getMethods() as $index => $method) {
            if ($index > 0) {
                Helper::echoBlankLine();
            }

            Helper::methodComment($method, 1);
            $returnTypeText = $method->hasReturnType() ? ': ' . $method->getReturnType() : '';
            Helper::el($method->getAccessLevel()->toText() . ' public static function ' . $method->getName() . '(' . Helper::methodArguments($method) . ')' . $returnTypeText, 1);
            Helper::el('{', 1);
            Helper::echoMethodBody($method, 2);
            Helper::e('}', 1);
        }
        Helper::el();
    }

}