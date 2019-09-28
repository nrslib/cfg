<?php

namespace nrslib\CfgTests;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;
use nrslib\Cfg\Meta\Words\AccessLevel;

class ClassTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {

    }

    public function testMyTest(): void
    {
        $meta = new ClassMeta('MyTestClass', 'nrslib');

        $meta->setupClass()
            ->addUse('nrslib\Cfg\ClassRenderer')
            ->addUse('nrslib\Cfg\Meta\Classes\ClassMeta')
            ->setExtend('SuperClass')
            ->addImplement('MyInterface')
            ->addImplement('MyInterface2')
            ->setConstructor(function ($define) {
                $define
                    ->addArgument('renderer', 'ClassRenderer')
                    ->addBody('$this->renderer = $renderer;')
                    ->addArgument('meta', 'ClassMeta')
                    ->addBody('$this->meta = $meta;');
            });

        $meta->setupFields()
            ->addField('testField', 'string')
            ->addField('testField2', 'string', AccessLevel::public())
            ->addField('renderer', 'ClassRenderer')
            ->addField('meta', 'ClassMeta');

        $meta->setupMethods()
            ->addMethod('test', function ($define) {
                $define->setAccessLevel(AccessLevel::public())
                    ->addArgument('test', 'string')
                    ->addArgument('test2', 'string');
            })
            ->addMethod('render', function ($define) {
                $define->setReturnType('void')
                    ->addBody('$this->renderer->render($this->meta);');
            });

        $compiler = new ClassRenderer();
        echo $compiler->render($meta);
    }
}
