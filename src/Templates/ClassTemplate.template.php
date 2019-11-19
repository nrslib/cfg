<?php
namespace nrslib\Cfg\Templates\Classes;

use nrslib\Cfg\Templates\Helper;
use nrslib\Cfg\Templates\ClassHelper;

?>
<?= "<?php" ?>


namespace <?= $class->getNamespace(); ?>;


<?php Helper::usingBlock($class); ?>
/**
 * Class <?= $class->getName(); ?>

 * @package <?= $class->getNamespace(); ?>

 */
class <?= $class->getName(); ?><?php ClassHelper::extendsBlock($class); ?><?php ClassHelper::implementsBlock($class); ?>

{
<?php ClassHelper::fieldBlock($fieldsSetting); ?>
<?php ClassHelper::constructorBlock($class, $class->getConstructor()); ?>
<?php ClassHelper::methodBlock($methodsSetting); ?>
}
