<?php

namespace Nextform\Security\Tests;

use Nextform\Security\Csrf\Generator\OpensslGenerator;
use Nextform\Security\Csrf\Models\TokenModel;
use PHPUnit\Framework\TestCase;

class CsrfTokenTest extends TestCase
{
    public function testOpensslGeneration()
    {
        foreach ([8, 16, 32, 64, 128, 256, 512] as $length) {
            $generator = new OpensslGenerator($length);

            $this->assertEquals(
                strlen($generator->generate('token_id')->value),
                floor($generator->bitLength / 8 * 2)
            );
        }
    }

    /**
     * @expectedException Nextform\Security\Csrf\Exception\GenerationFailedException
     */
    public function testInvalidOpensslGeneration()
    {
        $generator = new OpensslGenerator(2);
        $generator->generate('id');
    }

    public function testTokenModelSerialization()
    {
        $model = new TokenModel('token_id', 'token_value');
        $data = serialize($model);
        $newModel = unserialize($data);

        $this->assertEquals($model->value, $newModel->value);
        $this->assertEquals($model->created, $newModel->created);
    }
}
