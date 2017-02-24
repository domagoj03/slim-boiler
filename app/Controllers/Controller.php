<?php 

namespace App\Controllers;

use Interop\Container\ContainerInterface;

/**
* Controller
*/
abstract class Controller
{
    
    protected $c;

    function __construct(ContainerInterface $c)
    {
        $this->c = $c;
    }

}