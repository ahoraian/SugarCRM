<?php declare(strict_types=1);

namespace App\Services\AuthProviders;

use App\Services\Exceptions\HttpResponseException;
use App\Services\HttpClients\HttpClientInterface;
use App\Services\HttpClients\ResponseInterface;
use App\Services\Storage\StorageInterface;
use Throwable;

class SugarCrm implements AuthProviderInterface, HttpClientInterface
{
    const SESSION_KEY = 'sugarcrm';

    /**
     * SugarCrm constructor.
     * @param HttpClientInterface $client
     * @param StorageInterface $session
     * @param Token|null $token
     */
    public function __construct(private HttpClientInterface $client,
                                private StorageInterface $session,
                                private ?Token $token = null)
    {
        if ($this->session->has(self::SESSION_KEY)) {
            $this->token = $this->makeToken($this->session->get(self::SESSION_KEY));
        }
    }

    /**
     * Request for get token
     * @param array $params
     * @return Token
     */
    public function getToken(array $params): Token
    {
        // when session is not valid or not exists request for new token
        if (!($this->token && $this->isValid())) {
            // try to connect api endpoint and fetch result else throw an exception
            try {
                // create new token
                if ($this->token && $this->token->getRefreshToken()) {
                    $this->token = $this->refreshToken($params);
                } else {
                    $response = $this->client->post($params['url'], $params['data']);
                    $data = $response->getBody();

                    $this->token = $this->makeToken($data);
                }
            } catch (Throwable $e) {
                throw new HttpResponseException($e->getMessage(), $e->getCode());
            }
        }


        return $this->token;
    }

    /**
     * @param array $data
     * @return Token
     */
    private function makeToken(array $data): Token
    {
        $this->cacheToken($data);

        return new Token(
            $data['access_token'],
            $data['expires_in'],
            $data['token_type'],
            $data['scope'],
            $data['refresh_token'],
            $data['refresh_expires_in'],
            $data['download_token']
        );
    }

    /**
     * @param array $params
     * @return Token
     */
    public function refreshToken(array $params): Token
    {
        $response = $this->client->post($params['url'], [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->token->getRefreshToken(),
            'client_id' => $params['client_id'],
            'client_secret' => $params['client_id'],
        ]);
        $data = $response->getBody();

        return $this->makeToken($data);
    }

    public function cacheToken(array $data): void
    {
        // cached the token data
        $this->session->put(self::SESSION_KEY, array_merge($data, [
            'time' => time()
        ]));
    }

    /**
     * Check token is valid
     * @return bool
     */
    public function isValid(): bool
    {
        if (strtotime('+' . $this->token->getExpiresIn() . ' seconds') <= time()) {
            return false;
        }

        return true;
    }

    public function get(string $url, array $params = []): ResponseInterface
    {
        // set header by token
        $params['headers'] = $this->setRequestHeaders();

        return $this->client->get($url, $params);
    }

    public function post(string $url, array $params = []): ResponseInterface
    {
        // set header by token
        $params['headers'] = $this->setRequestHeaders();

        return $this->client->get($url, $params);
    }

    /**
     * Set Request headers
     * @return string[]
     */
    private function setRequestHeaders(): array
    {
        return [
            'Authorization: ' . ucfirst($this->token->getTokenType()) . ' ' . $this->token->getAccessToken()
        ];
    }
}