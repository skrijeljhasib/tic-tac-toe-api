<?php

namespace TicTacToe\UnitTest\Service;

use GeneratedHydrator\Configuration;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TicTacToe\Gateway\GameGateway;
use TicTacToe\Model\Move;
use TicTacToe\Model\Game;
use TicTacToe\Service\MoveService;
use TicTacToe\Validator\GameValidator;

/**
 * Class MoveServiceTest
 * @package TicTacToe\UnitTest\Service
 */
class MoveServiceTest extends TestCase
{
    /** @var GameGateway|MockObject $gameGateway */
    protected $gameGateway;

    /** @var GameValidator|MockObject $gameValidator */
    protected $gameValidator;

    /** @var MoveService|MockObject $moveService */
    protected $moveService;

    protected function setUp()
    {
        $this->gameValidator = $this->getMockBuilder(GameValidator::class)->getMock();
        $this->gameGateway = $this->getMockBuilder(GameGateway::class)->getMock();

        $config = new Configuration(Game::class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $gameHydrator = new $hydratorClass();

        $config = new Configuration(Move::class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $moveHydrator = new $hydratorClass();

        $this->moveService = new MoveService($this->gameValidator, $this->gameGateway, $gameHydrator, $moveHydrator);
    }

    public function testUpdateGame()
    {
        $move = new Move();
        $move->setId('1');
        $move->setGameId('1');
        $move->setBoardPosition(0);
        $move->setPlayer('Test1');

        $game = new Game();
        $game->setId('1');
        $game->setPlayerOne('Test1');
        $game->setPlayerTwo('Test2');

        $gameExtracted = $this->moveService->getGameHydrator()->extract($game);

        $this->gameGateway
            ->expects($this->once())
            ->method('find')
            ->with('1')
            ->willReturn($gameExtracted);

        $this->gameValidator
            ->expects($this->once())
            ->method('validateMove')
            ->with($game, $move)
            ->willReturn(true);

        $gameExtracted['board'][0] = 'Test1';
        $gameExtracted['playerToMove'] = 'Test2';

        $this->gameGateway
            ->expects($this->once())
            ->method('createOrUpdate')
            ->with($gameExtracted)
            ->willReturn(true);

        $result = $this->moveService->makeMove($move);

        $this->assertInstanceOf(Move::class, $result);
    }

    public function testUpdateGameHasAWinner()
    {
        $move = new Move();
        $move->setId('1');
        $move->setGameId('1');
        $move->setBoardPosition(2);
        $move->setPlayer('Test1');

        $game = new Game();
        $game->setId('1');
        $game->setPlayerToMove('Test1');
        $game->setPlayerOne('Test1');
        $game->setPlayerTwo('Test2');
        $game->setBoard([
            'Test1',
            'Test1',
            null,
            'Test2',
            'Test1',
            'Test2',
            'Test1',
            'Test2',
            'Test1',
        ]);

        $gameExtracted = $this->moveService->getGameHydrator()->extract($game);

        $this->gameGateway
            ->expects($this->once())
            ->method('find')
            ->with('1')
            ->willReturn($gameExtracted);

        $this->gameValidator
            ->expects($this->once())
            ->method('validateMove')
            ->with($game, $move)
            ->willReturn(true);

        $this->gameValidator
            ->expects($this->once())
            ->method('getWinnerBoards')
            ->willReturn([
                [0, 1, 2],
                [3, 4, 5],
                [6, 7, 8],
                [0, 4, 8],
                [2, 4, 6],
                [0, 3, 6],
                [1, 4, 7],
                [2, 5, 8]
            ]);

        $gameExtracted['board'][2] = 'Test1';
        $gameExtracted['playerToMove'] = 'Test2';
        $gameExtracted['winner'] = 'Test1';

        $this->gameGateway
            ->expects($this->once())
            ->method('createOrUpdate')
            ->with($gameExtracted)
            ->willReturn(true);

        $result = $this->moveService->makeMove($move);

        $this->assertInstanceOf(Move::class, $result);
    }
}
