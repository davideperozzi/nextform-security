<?php

namespace Nextform\Security\Csrf\Storage;

use Nextform\Security\Csrf\Models\TokenModel;
use Nextform\Security\Csrf\Exception\SessionNotStartedException;

class SessionStorage extends AbstractStorage
{
    /**
     * @var string
     */
    const STORAGE_KEY = 'nextform_csrf_token';


    public function __construct($storageKey = self::STORAGE_KEY)
    {
        if (session_status() == PHP_SESSION_NONE) {
            if (false == @session_start()) {
                throw new SessionNotStartedException(
                    'Something went wrong while starting the session.
                    Start it manually and make sure no header was
                    sent before the session is going to be started'
                );
            }
        }

        // Create empty storage if not defined
        if ( ! array_key_exists(self::STORAGE_KEY, $_SESSION)) {
            $_SESSION[self::STORAGE_KEY] = [];
        }
    }

    /**
     * @return array
     */
    private function getScope()
    {
        return $_SESSION[self::STORAGE_KEY];
    }

    /**
     * {@inheritDoc}
     */
    public function getToken($id)
    {
        $scope = $this->getScope();

        if ($this->containsToken($id)) {
            return unserialize($scope[$id]);
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function containsToken($id)
    {
        $scope = $this->getScope();

        if (array_key_exists($id, $scope)) {
            return ! empty($scope[$id]);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function setToken(TokenModel $token)
    {
        $_SESSION[self::STORAGE_KEY][$token->id] = serialize($token);

        return $token;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteToken($id)
    {
        if ($this->containsToken($id)) {
            unset($_SESSION[self::STORAGE_KEY][$id]);
        }
    }
}
