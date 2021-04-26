<?php declare(strict_types=1);

namespace App\Services\AuthProviders;

interface AuthProviderInterface
{
    /**
     * Request for token or read from cache [StorageStorage|File|...]
     * @param array $params
     * @return Token
     */
    public function getToken(array $params): Token;

    /**
     * @return mixed
     */
    public function isValid() : bool;
}