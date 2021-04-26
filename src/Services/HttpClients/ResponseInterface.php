<?php declare(strict_types=1);

namespace App\Services\HttpClients;

interface ResponseInterface
{
    /**
     * Retrieve the response body
     * Default based on json string output
     *
     * @return array|string|null
     */
    public function getBody(): array|string|null;

    /**
     * Retrieve the HTTP response status code
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Retrieve the HTTP response headers
     *
     * @return array
     */
    public function getHeaders(): array;
}