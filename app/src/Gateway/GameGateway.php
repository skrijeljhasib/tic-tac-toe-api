<?php

namespace TicTacToe\Gateway;

use Redis;

/**
 * Class GameGateway
 * @package TicTacToe\Gateway
 */
class GameGateway
{
    /** @var Redis $redis */
    protected $redis;

    /**
     * GameGateway constructor.
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param string $id
     * @return array
     * @throws \Exception
     */
    public function find(string $id): array
    {
        if (empty($this->redis->getKeys(sprintf('%s', $id)))) {
            throw new \Exception(sprintf('Can not find Game with id \'%s\'', $id), 404);
        }

        $result = json_decode($this->redis->get(sprintf('%s', $id)), true);
        $result['id'] = $id;

        return $result;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function createOrUpdate(array $data): bool
    {
        $key = $data['id'];
        unset($data['id']);
        
        return $this->redis->set($key, json_encode($data));
    }
}
