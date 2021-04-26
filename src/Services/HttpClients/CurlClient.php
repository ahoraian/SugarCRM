<?php declare(strict_types=1);

namespace App\Services\HttpClients;

use RuntimeException;

class CurlClient implements HttpClientInterface
{
    /**
     * @var string
     */
    private string $baseUrl;

    /**
     * @var false|resource
     */
    private $client;

    /**
     * @var int
     */
    private int $timeout;

    /**
     * HttpClient constructor.
     * @param string $baseUrl
     * @param int $timeout seconds
     */
    public function __construct(string $baseUrl, int $timeout = 30)
    {
        $this->baseUrl = $baseUrl;
        $this->timeout = $timeout;
        $this->client = curl_init();
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function get(string $url, array $params = []): ResponseInterface
    {
        $headers = [];
        if (array_key_exists('headers', $params)) {
            $headers = $params['headers'];
            unset($params['headers']);
        }

        $cnt = 1;
        $paramsCount = count($params);
        $url .= $paramsCount > 0 ? '?' : '';
        foreach ($params as $key => $param) {
            if (is_array($param)) {
                $param = json_encode($param);
            }
            $url .= "{$key}={$param}" . ($cnt < $paramsCount ? '&' : '');
            $cnt++;
        }

        return $this->request($url, $headers, $params);
    }

    /**
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function post(string $url, array $params = []): ResponseInterface
    {
        curl_setopt($this->client, CURLOPT_POST, 1);
        curl_setopt($this->client, CURLOPT_POSTFIELDS, $params);

        $headers = [];
        if (array_key_exists('headers', $params)) {
            $headers = $params['headers'];
            unset($params['headers']);
        }

        return $this->request($url, $headers, $params);
    }

    /**
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return ResponseInterface
     */
    public function request(string $url, array $headers, array $params = []): ResponseInterface
    {
        // set request url
        $url = $this->baseUrl . $url;
        curl_setopt($this->client, CURLOPT_URL, $url);
        curl_setopt($this->client, CURLOPT_HTTPHEADER, $headers);

        // set timeout for connection
        curl_setopt($this->client, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->client, CURLOPT_CONNECTTIMEOUT, $this->timeout);

        // set other options
        curl_setopt($this->client, CURLOPT_FAILONERROR, false);
        curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($this->client, CURLOPT_VERBOSE, 1);

        // execute curl and get response
        $res = curl_exec($this->client);

        // when curl can not fetch a url throw an error exception
        $error = curl_error($this->client);
        $errNo = curl_errno($this->client);
        if ($errNo !== 0) {
            throw new RuntimeException($error, $errNo);
        }

        // return response as array
        $response = new ArrayResponse();
        $response->setBody($res);
        $response->setStatusCode(curl_getinfo($this->client, CURLINFO_HTTP_CODE));

        curl_reset($this->client);
        curl_close($this->client);

        return $response;
    }
}