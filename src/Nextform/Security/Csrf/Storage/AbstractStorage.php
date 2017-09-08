<?php

namespace Nextform\Security\Csrf\Storage;

use Nextform\Security\Csrf\Models\TokenModel;

abstract class AbstractStorage
{
    /**
     * @param string $id
     * @return TokenModel
     */
    abstract public function getToken(string $id);

    /**
     * @param TokenModel $token
     * @return TokenModel
     */
    abstract public function setToken(TokenModel $token);

    /**
     * @param string $id
     * @return boolean
     */
    abstract public function containsToken(string $id);

    /**
     * @param string $id
     * @return boolean
     */
    abstract public function deleteToken(string $id);
}
