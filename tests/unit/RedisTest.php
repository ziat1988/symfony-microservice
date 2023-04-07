<?php
declare(strict_types=1);

namespace App\Tests\unit;

use App\Utils\RedisUtils;
use PHPUnit\Framework\TestCase;

class RedisTest extends TestCase
{
    public function testConnection()
    {
        // This is as same as Method Ping & pong with predis
        $client = RedisUtils::createConnectionRedis();
        $result= $client->ping();
        $this->assertTrue($result);
    }
}
