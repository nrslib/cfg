<?php


namespace nrslib\Cfg\Parser;


use nrslib\Cfg\Meta\Classes\ClassMeta;
use nrslib\Cfg\Parser\Builder\StatementBuilderFactory;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\ParserFactory;

/**
 * Class ClassParser
 * @package nrslib\Cfg\Parser
 */
class ClassParser
{
    private $statementBuilderFactory;

    public function __construct()
    {
        $this->statementBuilderFactory = new StatementBuilderFactory();
    }

    /**
     * @param string $contents
     * @return ClassMeta
     * @throws \Exception
     */
    public function parse(string $contents): ClassMeta
    {
        $parserFactory = new ParserFactory();
        $parser = $parserFactory->create(ParserFactory::PREFER_PHP7);
        $data = $parser->parse($contents);

        list($namespace, $uses, $clazz) = $this->splitData($data);

        $converter = new NodeToMetaConverter($this->statementBuilderFactory);
        $meta = $converter->convert($namespace, $uses, $clazz);

        return $meta;
    }

    /**
     * @param array $data
     * @return array [ Use_[] | Class_ ]
     * @throws \Exception
     */
    public function splitData(array $data): array
    {
        if (empty($data) || count($data) > 1) {
            throw new \Exception();
        }
        $namespace = $data[0]->name;
        $stmts = $data[0]->stmts;
        $uses = array_filter($stmts, function ($stmt) {
            return $stmt instanceof Stmt\Use_;
        });
        $uses = array_values($uses);
        $clazzes = array_filter($stmts, function ($stmt) {
            return $stmt instanceof Class_;
        });
        $clazzes = array_values($clazzes);

        if (empty($clazzes) || count($clazzes) > 1) {
            throw new \Exception("");
        }

        $clazz = $clazzes[0];

        return array($namespace, $uses, $clazz);
    }
}