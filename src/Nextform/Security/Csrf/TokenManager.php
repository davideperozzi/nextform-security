<?php

namespace Nextform\Security\Csrf;

use Nextform\Security\Csrf\Generator\AbstractGenerator;
use Nextform\Security\Csrf\Models\TokenModel;
use Nextform\Security\Csrf\Storage\AbstractStorage;

class TokenManager
{
    use TokenFactory;

    /**
     * @var AbstractStorage
     */
    private $stroage;

    /**
     * @var AbstractGenerator
     */
    private $generator;

    /**
     * @param AbstractStorage|null $storage
     * @param AbstractGenerator|null $generator
     */
    public function __construct(AbstractStorage $storage = null, AbstractGenerator $generator = null)
    {
        $this->storage = $storage ?: new Storage\SessionStorage();
        $this->generator = $generator ?: new Generator\OpensslGenerator();
    }

    /**
     * @param string $id
     * @return TokenModel
     */
    private function generateToken($id)
    {
        return $this->storage->setToken($this->generator->generate($id));
    }

    /**
     * @param string $id
     * @return TokenModel
     */
    public function getToken($id)
    {
        if ($this->storage->containsToken($id)) {
            return $this->storage->getToken($id);
        }

        return $this->generateToken($id);
    }

    /**
     * @param string $id
     * @return TokenModel
     */
    public function refreshToken($id)
    {
        return $this->generateToken($id);
    }

    /**
     * @param string $id
     * @return boolean
     */
    public function deleteToken($id)
    {
        $this->storage->deleteToken($id);
    }

    /**
     * @param TokenModel $token
     * @return boolean
     */
    public function isValidToken(TokenModel $token)
    {
        if ($this->storage->containsToken($token->id)) {
            $savedToken = $this->storage->getToken($token->id);

            return hash_equals($token->value, $savedToken->value);
        }

        return false;
    }
}
