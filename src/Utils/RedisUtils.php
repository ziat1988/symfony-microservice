<?php
declare(strict_types=1);

namespace App\Utils;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;

class RedisUtils
{
    public static function createConnectionRedis(): \Redis
    {
        $redisHost = getenv('REDIS_HOST');
        $redisPort = getenv('REDIS_PORT');

        return RedisAdapter::createConnection(sprintf('redis://%s:%s', $redisHost, $redisPort));

    }

    public static function getCache(\Redis $client): TagAwareAdapter
    {
        return new TagAwareAdapter(new RedisAdapter($client,namespace: 'my_app'));
    }

}
