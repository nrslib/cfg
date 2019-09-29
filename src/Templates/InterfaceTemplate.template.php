<?php
namespace nrslib\Cfg\Templates\Interfaces;

use nrslib\Cfg\Meta\Settings\InterfaceSetting;
use nrslib\Cfg\Meta\Settings\MethodsSetting;
use nrslib\Cfg\Templates\Helper;

require_once "Helper.php";
?>
<?= "<?php" ?>


namespace <?= $interface->getNamespace() ?>;


<?php Helper::usingBlock($interface) ?>
<?php Helper::usingBlock($interface); ?>
/**
 * Interface <?= $interface->getName(); ?>

 * @package <?= $interface->getNamespace(); ?>

*/
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
        Helper::methodComment($method, 1);
        $returnTypeText = $method->hasReturnType() ? ': ' . $method->getReturnType() : '';
        Helper::el(' function ' . $method->getName() . '(' . Helper::methodArguments($method) . ')' . $returnTypeText . ';', 1);
    }
}