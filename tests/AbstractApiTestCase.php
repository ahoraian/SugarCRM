<?php


namespace App\Tests;


use App\Services\AuthProviders\AuthProviderInterface;
use App\Services\AuthProviders\SugarCrm;
use App\Services\HttpClients\CurlClient;
use App\Services\Storage\ArrayStorage;
use PHPUnit\Framework\TestCase;

class AbstractApiTestCase extends TestCase
{
    /**
     * @var AuthProviderInterface
     */
    private AuthProviderInterface $client;


    protected function setUp(): void
    {
        parent::setUp();

        $this->client = (new SugarCrm(new CurlClient($_ENV['API_ENDPOINT']), new ArrayStorage));
    }

    /**
     * @return SugarCrm
     */
    public function getClient(): SugarCrm
    {
        return $this->client;
    }
}