<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\Dotenv\Dotenv;

/**
 * Register The Auto Loader
 */
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv;
$dotenv->load(__DIR__ . '/../.env');