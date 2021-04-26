<?php declare(strict_types=1);

namespace App\Services\HttpClients;

abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var string | array
     */
    protected string|array $body;

    /**
     * @var array
     */
    protected array $headers;

    /**
     * @var int
     */
    protected int $statusCode;

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array|string|null
     */
    public function getBody(): string|array|null
    {
        return $this->body;
    }

    /**
     * @param int $statusCode
     *
     * @return AbstractResponse
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = (int)$statusCode;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return AbstractResponse
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array|string $body
     *
     * @return ResponseInterface
     */
    public function setBody(string|array $body): ResponseInterface
    {
        $this->body = $body;

        return $this;
    }
}