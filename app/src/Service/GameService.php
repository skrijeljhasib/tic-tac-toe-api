<?php

namespace TicTacToe\Service;

use TicTacToe\Gateway\GameGateway;
use TicTacToe\Model\Game;
use Zend\Hydrator\HydratorInterface;

/**
 * Class GameService
 * @package TicTacToe\Service
 */
class GameService
{
    /** @var GameGateway $gameGateway */
    protected $gameGateway;

    /** @var HydratorInterface $gameHydrator */
    protected $gameHydrator;

    /**
     * GameService constructor.
     * @param GameGateway $gameGateway
     * @param HydratorInterface $gameHydrator
     */
    public function __construct(GameGateway $gameGateway, HydratorInterface $gameHydrator)
    {
        $this->setGameGateway($gameGateway);
        $this->setGameHydrator($gameHydrator);
    }

    /**
     * @param string $id
     * @return Game
     * @throws \Exception
     */
    public function findGame(string $id): Game
    {
        return $this->getGameHydrator()->hydrate($this->getGameGateway()->find($id), new Game());
    }

    /**
     * @param Game $game
     * @return Game
     * @throws \Exception
     */
    public function newGame(Game $game): Game
    {
        if (empty($game->getCreatedAt())) {
            $game->setCreatedAt(new \DateTime());
        }

        if (!$this->getGameGateway()->createOrUpdate($this->getGameHydrator()->extract($game))) {
            throw new \Exception('Something went wrong. Try again', 500);
        };

        return $game;
    }

    /**
     * @return GameGateway
     */
    public function getGameGateway(): GameGateway
    {
        return $this->gameGateway;
    }

    /**
     * @param GameGateway $gameGateway
     * @return GameService
     */
    public function setGameGateway(GameGateway $gameGateway): GameService
    {
        $this->gameGateway = $gameGateway;

        return $this;
    }

    /**
     * @return HydratorInterface
     */
    public function getGameHydrator(): HydratorInterface
    {
        return $this->gameHydrator;
    }

    /**
     * @param HydratorInterface $gameHydrator
     * @return GameService
     */
    public function setGameHydrator(HydratorInterface $gameHydrator): GameService
    {
        $this->gameHydrator = $gameHydrator;

        return $this;
    }
}
