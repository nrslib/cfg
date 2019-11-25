<?php

namespace nrslib\Cfg\Templates;


use nrslib\Cfg\Meta\Definitions\Fields\FieldDefinition;
use nrslib\Cfg\Meta\Definitions\Methods\MethodDefinitionInterface;
use nrslib\Cfg\Meta\Definitions\VariantDefinition;
use nrslib\Cfg\Meta\Settings\BasicSettingInterface;

class Helper
{
    public static function usingBlock(BasicSettingInterface $basicSetting)
    {
        if (!$basicSetting->anyUsing()) {
            return;
        }

        foreach ($basicSetting->getUsings() as $index => $using) {
            self::el('use ' . $using . ';');
        }

        self::el();
    }

    public static function fieldComment(FieldDefinition $field, $nest)
    {
        self::el('/** @var ' . $field->getVariableType() . ' */', $nest);
    }

    public static function methodComment(MethodDefinitionInterface $methodDefinition, int $nest, string $comment = null)
    {
        $args = $methodDefinition->getArguments();

        if (!$methodDefinition->hasReturnType(true) && count($args) <= 0) {
            self::el('/**', $nest);
            $comments = !is_null($comment) ? array_merge($methodDefinition->getComments(), [$comment]) : $methodDefinition->getComments();
            if (empty($comments)) {
                self::el(' *', $nest);
            } else {
                foreach ($comments as $comment) {
                    if ($comment) {
                        self::el(' * ' . $comment, $nest);
                    } else {
                        self::el(' *', $nest);
                    }
                }
            }
            self::el(' */', $nest);
            return;
        }

        self::el('/**', $nest);
        if (!is_null($comment)) {
            self::el(' * ' . $comment, $nest);
        }
        foreach ($args as $arg) {
            self::parameterComment($arg, $nest);
        }

        if ($methodDefinition->hasReturnType(true)) {
            self::el(' * @return ' . $methodDefinition->getReturnType(), $nest);
        }
        self::el(' */', $nest);
    }

    public static function parameterComment(VariantDefinition $arg, $nest)
    {
        $argComment = $arg->hasType() ? $arg->getType() . ' ' . $arg->getName() : $arg->getName();
        self::el(' * @param ' . $argComment, $nest);
    }

    public static function methodArguments(MethodDefinitionInterface $methodDefinition): string
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
    public static function e(string $text, int $nest = 0)
    {
        echo self::indent($nest) . $text;
    }

    /**
     * Echo Line with indent.
     * @param string $text
     * @param int $nest
     */
    public static function el(string $text = '', int $nest = 0)
    {
        echo self::indent($nest) . $text . '
';
    }

    public static  function echoBlankLine()
    {
        self::el();
        self::el();
    }

    public static function echoMethodBody(MethodDefinitionInterface $method, $nest)
    {
        foreach ($method->getBody() as $line) {
            self::el($line, $nest);
        }
    }

    public static function indent(int $nest)
    {
        $indent = '';
        for ($i = 0; $i < $nest; $i++) {
            $indent .= '    ';
        }
        return $indent;
    }
}