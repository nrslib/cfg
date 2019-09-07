<?php
namespace nrslib\Cfg\Templates\Classes;

use nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition;
use nrslib\Cfg\Meta\Settings\ClassSetting;
use nrslib\Cfg\Meta\Settings\FieldsSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;

require_once "TemplateHelper.php";

?>
<?= "<?php" ?>


namespace <?= $class->getNamespace() ?>;


<?php usingBlock($class) ?>
class <?= $class->getName(); ?><?php extendsBlock($class); ?><?php implementsBlock($class); ?>

{
<?php fieldBlock($fieldsSetting); ?>
<?php constructorBlock($class->getConstructor()); ?>
<?php methodBlock($methodsSetting); ?>
}

<?php
function extendsBlock(ClassSetting $classSetting)
{
    if (!$classSetting->hasExtend()) {
        return;
    }

    echo ' extends ' . $classSetting->getExtend();
}

function implementsBlock(ClassSetting $classSetting)
{
    if (!$classSetting->hasAnyImplements()) {
        return;
    }

    $implementObjects = implode(', ', $classSetting->getImplements());
    echo ' implements ' . $implementObjects;
}

function fieldBlock(FieldsSetting $fieldsSetting)
{
    if (!$fieldsSetting->hasAnyField()) {
        return;
    }

    foreach ($fieldsSetting->getFields() as $index => $field) {
        el($field->getAccessLevel()->toText() . ' ' . $field->getVariableName() . ';', 1);
    }

    el();
}

function constructorBlock(?ConstructorDefinition $constructorDefinition)
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

function methodBlock(MethodsSetting $methodsSetting)
{
    if (!$methodsSetting->hasAnyMethod()) {
        return;
    }

    foreach ($methodsSetting->getMethods() as $index => $method) {
        if ($index > 0) {
            echoBlankLine();
        }

        $returnTypeText = $method->hasReturnType() ? ': ' . $method->getReturnType() : '';
        el($method->getAccessLevel()->toText() . ' function ' . $method->getName() . '(' . methodArguments($method) . ')' . $returnTypeText, 1);
        el('{', 1);
        echoMethodBody($method, 2);
        e('}', 1);
    }
    el();
}
