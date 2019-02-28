<?php

namespace TicTacToe\UnitTest\Gateway;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TicTacToe\Gateway\GameGateway;

/**
 * Class GameGatewayTest
 * @package TicTacToe\UnitTest\Gateway
 */
class GameGatewayTest extends TestCase
{
    /** @var \Redis|MockObject $redis */
    protected $redis;

    /** @var GameGateway $gameGateway */
    protected $gameGateway;

    protected function setUp()
    {
        $this->redis = $this->createMock(\Redis::class);

        $this->gameGateway = new GameGateway($this->redis);
    }

    public function testFind()
    {
        $expectedGame['playerOne'] = 'Test1';
        $expectedGame['playerTwo'] = 'Test2';

        $json = json_encode($expectedGame);

        $this->redis
            ->expects($this->once())
            ->method('getKeys')
            ->with('1')
            ->willReturn(true);

        $this->redis
            ->expects($this->once())
            ->method('get')
            ->with('1')
            ->willReturn($json);

        $expectedGame = json_decode($json, true);
        $expectedGame['id'] = '1';

        $result = $this->gameGateway->find('1');

        $this->assertEquals($expectedGame, $result);
    }

    public function testFindNotFound()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can not find Game with id \'1\'');
        $this->expectExceptionCode(404);

        $this->redis
            ->expects($this->once())
            ->method('getKeys')
            ->with('1')
            ->willReturn(false);

        $this->gameGateway->find('1');
    }

    public function testCreateOrUpdate()
    {
        $game['playerOne'] = 'Test1';
        $game['playerTwo'] = 'Test2';

        $this->redis
            ->expects($this->once())
            ->method('set')
            ->with('1', json_encode($game))
            ->willReturn(true);

        $game['id'] = '1';

        $this->assertTrue($this->gameGateway->createOrUpdate($game));
    }
}
