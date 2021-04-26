<?php declare(strict_types=1);

namespace App\Services\HttpClients;

class JsonResponse extends AbstractResponse
{

    /**
     * JsonResponse constructor.
     * @param array $body
     * @param array|string[] $headers
     */
    public function __construct(array $body, array $headers = [])
    {
        $this->body = $body;
        $this->headers = array_merge([
            'Content-Type' => 'application/json'
        ], $headers);
    }

    /**
     * Turn json string response to array
     * @return string|null
     */
    public function getBody(): ?string
    {
        foreach ($this->headers as $key => $header) {
            header($key . ': ' . $header);
        }

        return json_encode($this->body);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getBody();
    }
}