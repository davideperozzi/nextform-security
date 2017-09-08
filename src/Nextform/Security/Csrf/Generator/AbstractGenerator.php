<?php

namespace Nextform\Security\Csrf\Generator;

use Nextform\Security\Csrf\TokenFactory;

abstract class AbstractGenerator
{
    use TokenFactory;

    /**
     * @param string $id
     * @return TokenModel
     */
    abstract public function generate($id);
}
