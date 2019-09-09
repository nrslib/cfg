<?php


namespace nrslib\Cfg\Meta\Settings;


/**
 * Interface BasicSettingInterface
 * @package nrslib\Cfg\Meta\Settings
 */
interface BasicSettingInterface
{
    /**
     * @return bool
     */
    function anyUsing(): bool;

    /**
     * @return string[]
     */
    function getUsings(): array;
}
