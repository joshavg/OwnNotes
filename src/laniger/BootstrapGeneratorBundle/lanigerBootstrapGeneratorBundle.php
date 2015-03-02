<?php
namespace laniger\BootstrapGeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class lanigerBootstrapGeneratorBundle extends Bundle
{

    /*
     * (non-PHPdoc)
     * @see \Symfony\Component\HttpKernel\Bundle\Bundle::getParent()
     */
    public function getParent()
    {
        return 'SensioGeneratorBundle';
    }
}
