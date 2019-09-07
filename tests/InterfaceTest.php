<?php


namespace nrslib\CfgTests;


use nrslib\Cfg\InterfaceRenderer;
use nrslib\Cfg\Meta\Interfaces\InterfaceMeta;
use PHPUnit\Framework\TestCase;

class InterfaceTest extends TestCase
{
    public function testMyInterface(): void
    {
        $meta = new InterfaceMeta('MyInterface', 'nrslib');

        $meta->getInterfaceSetting()
            ->addExtend('MyInterface')
            ->addExtend('MyInterface2');

        $meta->getMethodsSetting()
            ->addMethod('testMethod', function($define) {
                $define->addArgument('arg', 'string')
                    ->addArgument('arg2', 'string');
            })
            ->addMethod('testMethod2', function($define) {
                $define->setReturnType('void');
            });

        $renderer = new InterfaceRenderer();
        echo $renderer->render($meta);
    }
}