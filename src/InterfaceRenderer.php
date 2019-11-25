<?php


namespace nrslib\Cfg;


use nrslib\Cfg\Meta\Interfaces\InterfaceMeta;

class InterfaceRenderer
{
    /**
     * @param InterfaceMeta $meta
     * @return string
     */
    function render(InterfaceMeta $meta): string
    {
        $interface = $meta->getInterfaceSetting();
        $methodsSetting = $meta->getMethodsSetting();
        ob_start();
        include(__DIR__ . '/Templates/InterfaceTemplate.template.php');
        $data = ob_get_contents();
        ob_end_clean();
        return $data;
    }
}