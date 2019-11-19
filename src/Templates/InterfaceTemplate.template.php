<?php
namespace nrslib\Cfg\Templates\Interfaces;

use nrslib\Cfg\Templates\Helper;
use nrslib\Cfg\Templates\InterfaceHelper;

?>
<?= "<?php" ?>


namespace <?= $interface->getNamespace() ?>;


<?php Helper::usingBlock($interface) ?>
<?php Helper::usingBlock($interface); ?>
/**
 * Interface <?= $interface->getName(); ?>

 * @package <?= $interface->getNamespace(); ?>

*/
interface <?= $interface->getName(); ?><?php InterfaceHelper::extendsBlock($interface); ?>

{
<?php InterfaceHelper::methodBlock($methodsSetting); ?>
}
