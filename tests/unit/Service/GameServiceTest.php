<?php

namespace TicTacToe\UnitTest\Service;

use GeneratedHydrator\Configuration;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TicTacToe\Gateway\GameGateway;
use TicTacToe\Model\Game;
use TicTacToe\Service\GameService;
use TicTacToe\Validator\GameValidator;

/**
 * Class GameServiceTest
 * @package TicTacToe\UnitTest\Service
 */
class GameServiceTest extends TestCase
{
    /** @var GameService $gameService */
    protected $gameService;

    /** @var GameGateway|MockObject $gameGateway */
    protected $gameGateway;

    /** @var GameValidator|MockObject $gameValidator */
    protected $gameValidator;

    protected function setUp()
    {
        $this->gameValidator = $this->createMock(GameValidator::class);
        $this->gameGateway = $this->createMock(GameGateway::class);

        $config = new Configuration(Game::class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $gameHydrator = new $hydratorClass();

        $this->gameService = new GameService($this->gameValidator, $this->gameGateway, $gameHydrator);
    }

    public function testNewGame()
    {
        $game = new Game();
        $game->setPlayerOne('Test1');
        $game->setPlayerOne('Test2');
        $game->setCreatedAt(new \DateTime());

        $this->gameValidator
            ->expects($this->once())
            ->method('validateNewGame')
            ->with($game)
            ->willReturn(true);

        $this->gameGateway
            ->expects($this->once())
            ->method('createOrUpdate')
            ->with($this->gameService->getGameHydrator()->extract($game))
            ->willReturn(true);

        $result = $this->gameService->newGame($game);

        $this->assertInstanceOf(Game::class, $result);
    }

    public function testFindGame()
    {
        $game = new Game();
        $game->setPlayerOne('Test1');
        $game->setPlayerOne('Test2');
        $game->setCreatedAt(new \DateTime());

        $this->gameGateway
            ->expects($this->once())
            ->method('find')
            ->with('1')
            ->willReturn($this->gameService->getGameHydrator()->extract($game));

        $result = $this->gameService->findGame('1');

        $this->assertInstanceOf(Game::class, $result);
    }
}
