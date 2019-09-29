<?php
namespace nrslib\Cfg\Templates\Classes;

use nrslib\Cfg\Meta\Definitions\Methods\ConstructorDefinition;
use nrslib\Cfg\Meta\Settings\ClassSetting;
use nrslib\Cfg\Meta\Settings\FieldsSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;
use nrslib\Cfg\Templates\Helper;

require_once "Helper.php";

?>
<?= "<?php" ?>


namespace <?= $class->getNamespace(); ?>;


<?php Helper::usingBlock($class); ?>
/**
 * Class <?= $class->getName(); ?>

 * @package <?= $class->getNamespace(); ?>

 */
class <?= $class->getName(); ?><?php extendsBlock($class); ?><?php implementsBlock($class); ?>

{
<?php fieldBlock($fieldsSetting); ?>
<?php constructorBlock($class, $class->getConstructor()); ?>
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
        Helper::fieldComment($field, 1);
        Helper::el($field->getAccessLevel()->toText() . ' ' . $field->getVariableName() . ';', 1);
    }

    Helper::el();
}

function constructorBlock(ClassSetting $classSetting, ?ConstructorDefinition $constructorDefinition)
{
    if (is_null($constructorDefinition)) {
        return;
    }

    Helper::methodComment($constructorDefinition, 1, $classSetting->getName() . ' constructor.');
    Helper::el(\nrslib\Cfg\Meta\Words\AccessLevel::public()->toText() . ' function __construct(' . Helper::methodArguments($constructorDefinition) . ')', 1);
    Helper::el('{', 1);
    Helper::echoMethodBody($constructorDefinition, 2);
    Helper::el('}', 1);
    Helper::el();
}

function methodBlock(MethodsSetting $methodsSetting)
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
        Helper::el($method->getAccessLevel()->toText() . ' function ' . $method->getName() . '(' . Helper::methodArguments($method) . ')' . $returnTypeText, 1);
        Helper::el('{', 1);
        Helper::echoMethodBody($method, 2);
        Helper::e('}', 1);
    }
    Helper::el();
}
