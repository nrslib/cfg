<?php

namespace App\Http\Controllers\Test;


use Illuminate\Routing\Controller as BaseController;
use packages\InputPorts\Test\TestMyActionInputPortInterface;

/**
 * Class TestController
 * @package App\Http\Controllers\Test
 */
class TestController extends BaseController
{
    /**
     * @param TestMyActionInputPortInterface $inputPort
     */
    private function myAction(TestMyActionInputPortInterface $inputPort)
    {
        // TODO: Implement myAction() method.
    }
}
