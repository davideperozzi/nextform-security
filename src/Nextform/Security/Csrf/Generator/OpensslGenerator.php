<?php

namespace Nextform\Security\Csrf\Generator;

use Nextform\Security\Csrf\Exception\GenerationFailedException;
use Nextform\Security\Csrf\Exception\OpensslNotFoundException;
use Nextform\Security\Csrf\Models\TokenModel;

class OpensslGenerator extends AbstractGenerator
{
    /**
     * @var integer
     */
    public $bitLength = 0;

    /**
     * @var boolean
     */
    private $strong = true;

    /**
     * @param integer $bitLength
     * @param boolean $strong
     * @throws OpensslNotFoundException if OpenSSL extension was not found
     */
    public function __construct($bitLength = 128, $strong = true)
    {
        if ( ! function_exists('openssl_random_pseudo_bytes')) {
            throw new OpensslNotFoundException(
                'OpenSSL needs to be installed to use this generator'
            );
        }

        $this->bitLength = $bitLength;
    }

    /**
     * @param string $id
     * @throws GenerationFailedException if openssl is not working properly
     * @return TokenModel
     */
    public function generate($id)
    {
        $bytes = openssl_random_pseudo_bytes($this->bitLength / 8, $this->strong);

        if (false == $bytes) {
            throw new GenerationFailedException(
                sprintf('Something went wrong while generating random bytes %s', $this->bitLength)
            );
        }

        return $this->createToken($id, bin2hex($bytes));
    }
}
