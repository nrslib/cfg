<?php
namespace nrslib\Cfg\Templates\Interfaces;

require_once "TemplateHelper.php";
?>
<?= "<?php" ?>


namespace <?= $interface->getNamespace() ?>;


<?php usingBlock($interface) ?>
interface <?= $interface->getName(); ?>

{
<?php methodBlock($methodsSetting); ?>
}

<?php

function methodBlock(\nrslib\Cfg\Meta\Settings\MethodsSetting $methodsSetting)
{
    if (!$methodsSetting->hasAnyMethod()) {
        return;
    }

    foreach ($methodsSetting->getMethods() as $index => $method) {
        el(' function ' . $method->getName() . '(' . methodArguments($method) . ');', 1);
    }
}