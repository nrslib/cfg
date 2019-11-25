<?php


namespace nrslib\Cfg\Parser\Builder;


use PhpParser\Comment;
use PhpParser\Node\Stmt\Nop;
use PhpParser\PrettyPrinter\Standard;

class NopBuilder implements StatementBuilderInterface
{
    private $nop;

    public function __construct(Nop $nop)
    {
        $this->nop = $nop;
    }

    function build(): array
    {
        $comments = $this->nop->getComments();
        if (empty($comments)) {
            return [];
        }

        $printer = new Standard();
        $texts = $printer->prettyPrint([$this->nop]);
        $splits = explode("\n", $texts);
        return $splits;
    }

    private function commentToText(Comment $comment): string
    {
        $printer = new Standard();
        return 'aaa';
    }
}