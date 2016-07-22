<?php

namespace Front\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FrontUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
