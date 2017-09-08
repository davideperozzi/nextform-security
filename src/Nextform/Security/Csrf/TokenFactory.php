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
    public function createToken(string $id, string $value): TokenModel
    {
        return new TokenModel($id, $value);
    }
}
