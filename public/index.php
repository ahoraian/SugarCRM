<?php declare(strict_types=1);

// check application speed (with large array)
$startTime = microtime(true);

use App\Services\AuthProviders\SugarCrm;
use App\Services\HttpClients\CurlClient;
use App\Services\Storage\StorageStorage;
use App\Services\Template\Template;
use Symfony\Component\Dotenv\Dotenv;
use App\Config\Config;

/**
 * Register The Auto Loader
 */
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv;
$dotenv->load(__DIR__ . '/../.env');

/**
 * Load app configs
 */
$configs = new Config($_ENV);

/**
 * Inject an http client like Curl, GuzzleHttp, ...
 */
$httpClient = new CurlClient($configs->get('API_ENDPOINT'));

// start session when set configuration SESSION_DRIVER=StorageStorage
$storageDriver = null;
if ($configs->get('SESSION_DRIVER') == 'Session') {
    session_start();
    $storageDriver = new StorageStorage;
}

/**
 * Get Token
 */
$sugarcrm = new SugarCrm($httpClient, $storageDriver);
$sugarcrm->getToken([
    'url' => '/oauth2/token',
    'data' => [
        'client_id' => $configs->get('SUGARCRM_CLIENT_ID'),
        'client_secret' => $configs->get('SUGARCRM_CLIENT_SECRET'),
        'grant_type' => $configs->get('SUGARCRM_GRANT_TYPE'),
        'username' => $configs->get('SUGARCRM_USERNAME'),
        'password' => $configs->get('SUGARCRM_PASSWORD'),
        'platform' => $configs->get('SUGARCRM_PLATFORM')
    ]
]);

// get amount form GET
$amount = $_GET['amount'] ?? 0;

// get opportunities
$response = $sugarcrm->get('/Opportunities', ['filter' => [['amount' => ['$gte' => $amount]]]]);
$opportunities = $response->getBody()['records'];

// unique accounts
$uniqueAccounts = [];
foreach ($opportunities as $opportunity) {
    $uniqueAccounts[$opportunity['account_id']][] = $opportunity;
}

// fetch accounts (with $in just one time send request for get all accounts)
$response = $sugarcrm->get('/Accounts', ['filter' => [['id' => ['$in' => array_keys($uniqueAccounts)]]]]);
$accounts = $response->getBody()['records'];

// hold all opportunities for accounts [show detail in html]
foreach ($accounts as $key => $account) {
    $accounts[$key]['opportunities'] = $uniqueAccounts[$account['id']];
}

// html
$view = new Template('../src/Views');
$view->amount = $amount;
$view->accounts = json_encode($accounts);

//$view->opportunities = $opportunities;
echo $view->render('index.html');
