<?php


namespace nrslib\Cfg\Meta\Words;


final class AccessLevel
{
    private const PUBLIC = 0;
    private const PROTECTED = 1;
    private const PRIVATE = 2;

    private $level;

    public function __construct($level)
    {
        $this->level = $level;
    }

    public static function public(): self
    {
        return new self(self::PUBLIC);
    }

    public static function protected(): self
    {
        return new self(self::PROTECTED);
    }

    public static function private(): self
    {
        return new self(self::PRIVATE);
    }

    public function toText()
    {
        switch ($this->level) {
            case self::PUBLIC:
                return 'public';
            case self::PROTECTED:
                return 'protected';
            case self::PRIVATE:
                return 'private';
            default:
                throw new \Exception();
        }
    }
}