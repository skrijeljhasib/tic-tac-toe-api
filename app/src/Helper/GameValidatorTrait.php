<?php

namespace TicTacToe\Helper;

use TicTacToe\Validator\GameValidator;

/**
 * Trait GameValidatorTrait
 * @package TicTacToe\Helper
 */
trait GameValidatorTrait
{
    /** @var GameValidator $gameValidator */
    protected $gameValidator;

    /**
     * @return GameValidator
     */
    public function getGameValidator(): GameValidator
    {
        return $this->gameValidator;
    }

    /**
     * @param GameValidator $gameValidator
     * @return self
     */
    public function setGameValidator(GameValidator $gameValidator): self
    {
        $this->gameValidator = $gameValidator;

        return $this;
    }
}
