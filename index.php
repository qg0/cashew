<?php

require_once 'vendor/autoload.php';

use App\CacheManager;
use Aviat\Banker\Pool;
use Psr\Log\NullLogger;
use App\CacheConnection;
use App\HttpClientGuzzle;

$host = 'hostname';
$user = 'user';
$pass = 'password';

$requestArray = ['foo' => 'bar'];

$config = [
    'driver'     => 'null', // null, apcu, redis, memcached
    'connection' => [
        // Optional (For some drivers):
        // driver setup, see below for the structure for each
        // driver
    ],
    'options' => [
        // Optional:
        // Set additional driver-specific options, like persistence for
        // Memcached, or a prefix for Redis keys
    ],
];

$pool       = new Pool($config);
$connection = new CacheConnection($host, $user, $pass);
$client     = new HttpClientGuzzle($connection, $requestArray);
$logger     = new NullLogger();
$expiresAt  = 'Now + 1 Day';

$manager = new CacheManager($client, $pool, $logger, $expiresAt);

echo 'ok';
