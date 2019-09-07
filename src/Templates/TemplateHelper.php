<?php

class TemplateHelper
{

}
function usingBlock(\nrslib\Cfg\Meta\Settings\BasicSettingInterface $basicSetting)
{
    if (!$basicSetting->anyUsing()) {
        return;
    }

    foreach($basicSetting->getUsings() as $index => $using) {
        el('use ' . $using);
    }

    el();
}

function methodArguments(\nrslib\Cfg\Meta\Definitions\Methods\MethodDefinitionInterface $methodDefinition): string
{
    $tokens = [];
    foreach ($methodDefinition->getArguments() as $argument) {
        if ($argument->hasType()) {
            $token = $argument->getName();
        } else {
            $token = $argument->getType() . ' ' . $argument->getName();
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

function echoMethodBody(\nrslib\Cfg\Meta\Definitions\Methods\MethodDefinitionInterface $method, $nest)
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
