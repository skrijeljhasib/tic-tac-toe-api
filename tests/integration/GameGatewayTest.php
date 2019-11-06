<?php

namespace TicTacToe\IntegrationTest;

use Codeception\TestCase\Test;
use IntegrationTester;
use Redis;
use TicTacToe\Gateway\GameGateway;

class GameGatewayTest extends Test
{
    /** @var GameGateway */
    private $subject;

    /** @var IntegrationTester */
    public $tester;

    protected function _before()
    {
        $redis = new Redis();
        $redis->connect('redis');

        $this->subject = new GameGateway($redis);
    }


    public function testCreateGame()
    {
        $data = [
            'id' => '1',
            'playerOne' => 'Max',
            'playerTwo' => 'Peter',
        ];

        $result = $this->subject->createOrUpdate($data);

        $this->assertTrue($result);

        $id = $data['id'];
        unset($data['id']);

        $this->tester->seeInRedis($id, json_encode($data));
    }

    protected function _after()
    {
        $this->tester->cleanup();
    }
}
