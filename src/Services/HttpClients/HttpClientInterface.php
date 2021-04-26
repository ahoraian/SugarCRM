<?php declare(strict_types=1);

namespace App\Services\HttpClients;

interface HttpClientInterface
{
    /**
     * Fetch a remote url with GET method
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function get(string $url, array $params = []) : ResponseInterface;

    /**
     * Fetch a remote url with POST method
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function post(string $url, array $params = []) : ResponseInterface;
}