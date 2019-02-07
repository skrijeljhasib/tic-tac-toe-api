<?php

namespace TicTacToe\Helper;

use TicTacToe\Gateway\GameGateway;

/**
 * Trait GameGatewayTrait
 * @package TicTacToe\Helper
 */
trait GameGatewayTrait
{
    /** @var GameGateway $gameGateway */
    protected $gameGateway;

    /**
     * @return GameGateway
     */
    public function getGameGateway(): GameGateway
    {
        return $this->gameGateway;
    }

    /**
     * @param GameGateway $gameGateway
     * @return self
     */
    public function setGameGateway(GameGateway $gameGateway): self
    {
        $this->gameGateway = $gameGateway;

        return $this;
    }
}
