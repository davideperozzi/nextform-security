<?php

namespace Nextform\Security\Csrf;

use Nextform\Security\Csrf\Models\TokenModel;

trait TokenFactory
{
    /**
     * @param string $id
     * @param string $value
     * @return TokenModel
     */
    public function createToken($id, $value)
    {
        return new TokenModel($id, $value);
    }
}
