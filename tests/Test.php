<?php

namespace nrslib\CfgTests;

use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;
use nrslib\Cfg\Meta\Words\AccessLevel;

class Test extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {

    }

    public function testMyTest(): void
    {
        $meta = new ClassMeta();
        $meta->setupClass()
            ->setName("MyTestClass")
            ->setNamespace("nrslib")
            ->setConstructor(function ($define) {
                $define->addArgument('testField', 'string')
                    ->addBody('$this->testField = $testField;');
            });
        $meta->setupFields()
            ->addField('testField', 'string')
            ->addField('testField2', 'string', AccessLevel::public());
        $meta->setupMethods()
            ->addMethod('test', function ($define) {
                $define->setAccessLevel(AccessLevel::public())
                    ->addArgument('test', 'string')
                    ->addArgument('test2', 'string');
            })
            ->addMethod('test2', function ($define) {
                $define->addBody('$testField = 1;');
            });
        $compiler = new ClassRenderer();
        echo $compiler->render($meta);
    }
}
