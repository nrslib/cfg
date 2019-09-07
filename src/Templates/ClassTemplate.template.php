<?php
namespace nrslib\Cfg\Templates\Classes;

require_once "TemplateHelper.php";

?>
<?= "<?php" ?>


namespace <?= $class->getNamespace() ?>;


<?php usingBlock($class) ?>
class <?= $class->getName(); ?>

{
<?php fieldBlock($fieldsSetting); ?>
<?php constructorBlock($class->getConstructor()); ?>
<?php methodBlock($methodsSetting); ?>
}

<?php
function fieldBlock(\nrslib\Cfg\Meta\Settings\FieldsSetting $fieldsSetting)
{
    if (!$fieldsSetting->hasAnyField()) {
        return;
    }

    foreach ($fieldsSetting->getFields() as $index => $field) {
        el($field->getAccessLevel()->toText() . ' ' . $field->getVariableName() . ';', 1);
    }

    el();
}

function constructorBlock(?\nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition $constructorDefinition)
{
    if (is_null($constructorDefinition)) {
        return;
    }

    el(\nrslib\Cfg\Meta\Words\AccessLevel::public()->toText() . ' function __construct(' . methodArguments($constructorDefinition) . ')', 1);
    el('{', 1);
    echoMethodBody($constructorDefinition, 2);
    el('}', 1);
    el();
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
    el();
}
