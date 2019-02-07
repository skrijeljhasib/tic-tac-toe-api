<?php

namespace TicTacToe\Helper;

use Zend\Hydrator\HydratorInterface;

/**
 * Trait GameHydratorTrait
 * @package TicTacToe\Helper
 */
trait GameHydratorTrait
{
    /** @var HydratorInterface $gameHydrator */
    protected $gameHydrator;

    /**
     * @return HydratorInterface
     */
    public function getGameHydrator(): HydratorInterface
    {
        return $this->gameHydrator;
    }

    /**
     * @param HydratorInterface $gameHydrator
     * @return self
     */
    public function setGameHydrator(HydratorInterface $gameHydrator): self
    {
        $this->gameHydrator = $gameHydrator;

        return $this;
    }
}
