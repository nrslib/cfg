<?php
namespace nrslib\Cfg\Templates\Interfaces;

use function foo\func;
use nrslib\Cfg\Meta\Settings\InterfaceSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;

require_once "TemplateHelper.php";
?>
<?= "<?php" ?>


namespace <?= $interface->getNamespace() ?>;


<?php usingBlock($interface) ?>
interface <?= $interface->getName(); ?><?php extendsBlock($interface); ?>

{
<?php methodBlock($methodsSetting); ?>
}

<?php

function extendsBlock(InterfaceSetting $interfaceSetting)
{
    if (!$interfaceSetting->hasAnyExtend()) {
        return;
    }

    $extendObjects = implode(', ', $interfaceSetting->getExtends());
    echo ' extends ' . $extendObjects;
}

function methodBlock(MethodsSetting $methodsSetting)
{
    if (!$methodsSetting->hasAnyMethod()) {
        return;
    }

    foreach ($methodsSetting->getMethods() as $index => $method) {
        $returnTypeText = $method->hasReturnType() ? ': ' . $method->getReturnType() : '';
        el(' function ' . $method->getName() . '(' . methodArguments($method) . ')' . $returnTypeText . ';', 1);
    }
}