<?php

use nrslib\Cfg\Meta\Definitions\Fields\FieldDefinition;
use nrslib\Cfg\Meta\Definitions\Methods\MethodDefinitionInterface;
use nrslib\Cfg\Meta\Definitions\VariantDefinition;
use nrslib\Cfg\Meta\Settings\BasicSettingInterface;

class TemplateHelper
{

}

function usingBlock(BasicSettingInterface $basicSetting)
{
    if (!$basicSetting->anyUsing()) {
        return;
    }

    foreach ($basicSetting->getUsings() as $index => $using) {
        el('use ' . $using . ';');
    }

    el();
}

function fieldComment(FieldDefinition $field, $nest) {
    el('/** @var ' . $field->getVariableType() . ' */', $nest);
}

function methodComment(MethodDefinitionInterface $methodDefinition, int $nest, string $comment = null)
{
    $args = $methodDefinition->getArguments();

    if (!$methodDefinition->hasReturnType(true) && count($args) <= 0) {
        el('/**', $nest);
        el(' * ' . $comment, $nest);
        el(' */', $nest);
        return;
    }

    el('/**', $nest);
    if (!is_null($comment)) {
        el(' * '. $comment, $nest);
    }
    foreach ($args as $arg) {
        parameterComment($arg, $nest);
    }

    if ($methodDefinition->hasReturnType(true)) {
        el(' * @return ' . $methodDefinition->getReturnType(), $nest);
    }
    el(' */', $nest);
}

function parameterComment(VariantDefinition $arg, $nest) {
    $argComment = $arg->hasType() ? $arg->getType() . ' ' . $arg->getName() : $arg->getName();
    el(' * @param ' . $argComment, $nest);
}

function methodArguments(MethodDefinitionInterface $methodDefinition): string
{
    $tokens = [];
    foreach ($methodDefinition->getArguments() as $argument) {
        if ($argument->hasType()) {
            $token = $argument->getType() . ' ' . $argument->getName();
        } else {
            $token = $argument->getName();
        }

        array_push($tokens, $token);
    }
    $result = implode(', ', $tokens);

    return $result;
}

/**
 * Echo with indent.
 * @param string $text
 * @param int $nest
 */
function e(string $text, int $nest = 0)
{
    echo indent($nest) . $text;
}

/**
 * Echo Line with indent.
 * @param string $text
 * @param int $nest
 */
function el(string $text = '', int $nest = 0)
{
    echo indent($nest) . $text . '
';
}

function echoBlankLine()
{
    el();
    el();
}

function echoMethodBody(MethodDefinitionInterface $method, $nest)
{
    foreach ($method->getBody() as $line) {
        el($line, $nest);
    }
}

function indent(int $nest)
{
    $indent = '';
    for ($i = 0; $i < $nest; $i++) {
        $indent .= '    ';
    }
    return $indent;
}
