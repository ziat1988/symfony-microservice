<?php
declare(strict_types=1);

namespace App\Tests\unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class RedisTest extends TestCase
{
    public function testConnection()
    {
        $redisHost = getenv('REDIS_HOST');
        $redisPort = getenv('REDIS_PORT');
        $client = RedisAdapter::createConnection(sprintf('redis://%s:%s', $redisHost, $redisPort));

        $result= $client->ping();
        $this->assertTrue($result);

        // Method Ping & pong with predis

    }
}
