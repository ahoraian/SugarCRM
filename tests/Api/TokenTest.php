<?php declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\AbstractApiTestCase;
use Throwable;

class TokenTest extends AbstractApiTestCase
{
    /**
     * Test get response
     * @throws Throwable
     */
    public function testResponse()
    {
        $token = $this->getClient()
            ->getToken([
                'url' => '/oauth2/token',
                'data' => [
                    'grant_type' => $_ENV['SUGARCRM_GRANT_TYPE'],
                    'client_id' => $_ENV['SUGARCRM_CLIENT_ID'],
                    'client_secret' => $_ENV['SUGARCRM_CLIENT_SECRET'],
                    'username' => $_ENV['SUGARCRM_USERNAME'],
                    'password' => $_ENV['SUGARCRM_PASSWORD'],
                    'platform' => $_ENV['SUGARCRM_PLATFORM']
                ]
            ]);

        $this->assertIsString($token->getAccessToken());
        $this->assertNotEmpty($token->getTokenType());
    }
}