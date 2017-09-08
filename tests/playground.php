<?php

require realpath(__DIR__ . '/../vendor/autoload.php');

use Nextform\Security\Csrf\TokenManager;

$tokenManager = new TokenManager();

$tokenId = 'nextform_238j48jsl74jfn7j';

$token = $tokenManager->getToken($tokenId);
$token2 = $tokenManager->createToken($tokenId, 'af27c4892c51c5371e2bad144e8bd7b0');

var_dump($tokenManager->isValidToken($token2));
print_r($tokenManager->getToken($tokenId));

$tokenManager->deleteToken($tokenId);
