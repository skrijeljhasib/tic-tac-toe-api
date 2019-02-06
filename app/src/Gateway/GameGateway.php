<?php

namespace TicTacToe\Gateway;

use Redis;

/**
 * Class GameGateway
 * @package TicTacToe\Gateway
 */
class GameGateway
{
    /** @var string $redisHost */
    protected $redisHost = '';

    /** @var Redis $redis */
    protected $redis;

    /**
     * @param string $id
     * @return array
     * @throws \Exception
     */
    public function find(string $id): array
    {
        $this->getRedis()->connect($this->getRedisHost());
        if (empty($this->getRedis()->getKeys(sprintf('%s', $id)))) {
            throw new \Exception(sprintf('Can not find Game with id \'%s\'', $id), 404);
        }

        $result = json_decode($this->getRedis()->get(sprintf('%s', $id)), true);
        $result['id'] = $id;

        return $result;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function createOrUpdate(array $data): bool
    {
        $this->getRedis()->connect($this->getRedisHost());
        $key = $data['id'];
        unset($data['id']);
        
        return $this->getRedis()->set($key, json_encode($data));
    }

    /**
     * @return Redis
     */
    public function getRedis(): Redis
    {
        return $this->redis;
    }

    /**
     * @param Redis $redis
     * @return GameGateway
     */
    public function setRedis(Redis $redis): GameGateway
    {
        $this->redis = $redis;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedisHost(): string
    {
        return $this->redisHost;
    }

    /**
     * @param string $redisHost
     * @return GameGateway
     */
    public function setRedisHost(string $redisHost): GameGateway
    {
        $this->redisHost = $redisHost;

        return $this;
    }
}
