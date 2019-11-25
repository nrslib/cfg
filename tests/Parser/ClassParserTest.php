<?php


namespace nrslib\CfgTests\Parser;


use nrslib\Cfg\ClassRenderer;
use nrslib\Cfg\Parser\ClassParser;
use PHPUnit\Framework\TestCase;

class ClassParserTest extends TestCase
{
    public function setup()
    {
    }

    public function testParse()
    {
        $parser = new ClassParser();
        $contents = file_get_contents('.\\tests\\Parser\\AppServiceProvider.php');
        $meta = $parser->parse($contents);
        $renderer = new ClassRenderer();
        $contents = $renderer->render($meta);
        file_put_contents('.\\tests\\Parser\\output.php', $contents);
    }
}