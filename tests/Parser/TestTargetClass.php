<?php

namespace nrslib;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Meta\Classes\ClassMeta;

/**
 * Class TestTargetClass
 * @package nrslib
 */
class TestTargetClass extends SuperClass implements MyInterface, MyInterface2
{
    /** @var string */
    private $testField;
    /** @var string */
    public $testField2;
    /** @var ClassRenderer */
    private $renderer;
    /** @var ClassMeta */
    private $meta;

    /**
     * TestTargetClass constructor.
     * @param ClassRenderer $renderer
     * @param ClassMeta $meta
     */
    public function __construct(ClassRenderer $renderer, ClassMeta $meta)
    {
        $this->renderer = $renderer;
        $this->meta = $meta;
    }

    /**
     * @param string $test
     * @param string $test2
     */
    public function test(string $test, string $test2)
    {
    }

    /**
     *
     */
    private function render(): void
    {
        $this->renderer->render($this->meta);
    }
}
