<?= "<?php" ?>



namespace <?= $class->getNamespace() ?>;


class <?= $class->getName(); ?>

{
<?php fieldBlock($fieldsSetting); ?>
<?php constructorBlock($class->getConstructor()); ?>
<?php methodBlock($methodsSetting); ?>
}

<?php
function fieldBlock(\nrslib\Cfg\Meta\Settings\FieldsSetting $fieldsSetting) {
    if (!$fieldsSetting->hasAnyField()) {
        return;
    }

    foreach($fieldsSetting->getFields() as $index => $field) {
        el($field->getAccessLevel()->toText() . ' ' . $field->getVariableName() . ';', 1);
    }

    el('');
}

function constructorBlock(?\nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition $constructorDefinition)
{
    if(is_null($constructorDefinition)) {
        return;
    }

    el(\nrslib\Cfg\Meta\Words\AccessLevel::public()->toText() . ' function __construct(' . methodArguments($constructorDefinition) . ')', 1);
    el('{', 1);
    echoMethodBody($constructorDefinition, 2);
    el('}', 1);
    el('');
}

function methodBlock(\nrslib\Cfg\Meta\Settings\MethodsSetting $methodsSetting)
{
    if (!$methodsSetting->hasAnyMethod()) {
        return;
    }

    foreach ($methodsSetting->getMethods() as $index => $method) {
        if ($index > 0) {
            echoBlankLine();
        }
        el($method->getAccessLevel()->toText() . ' function ' . $method->getName() . '(' . methodArguments($method) . ')', 1);
        el('{', 1);
        echoMethodBody($method, 2);
        e('}', 1);
    }
    el('');
}

function methodArguments(\nrslib\Cfg\Meta\Definitions\Methods\MethodDefinitionInterface $methodDefinition) : string
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

function e(string $text, int $nest = 0)
{
    echo indent($nest) . $text;
}

function el(string $text, int $nest = 0)
{
    echo indent($nest) . $text . '
';
}

function echoBlankLine() {
    el('');
    el('');
}

function echoMethodBody(\nrslib\Cfg\Meta\Definitions\Methods\MethodDefinitionInterface $method, $nest){
    foreach ($method->getBody() as $line) {
        el($line, $nest);
    }
}

function indent(int $nest)
{
    $indent = '';
    for($i = 0; $i < $nest; $i++) {
        $indent .= '    ';
    }
    return $indent;
}
?>

