<?php

namespace TicTacToe\Model;

/**
 * Class Move
 * @package TicTacToe\Model
 * @OA\Schema()
 */
class Move
{
    /**
     * @var string $id
     * @OA\Property()
     */
    protected $id;

    /**
     * @var string $player
     * @OA\Property()
     */
    protected $player;

    /**
     * @var string $gameId
     * @OA\Property()
     */
    protected $gameId;

    /**
     * @var int $boardPosition
     * @OA\Property()
     */
    protected $boardPosition;

    /**
     * @var \DateTime $createdAt
     * @OA\Property(readOnly = true)
     */
    protected $createdAt;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Move
     */
    public function setId(string $id): Move
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlayer(): string
    {
        return $this->player;
    }

    /**
     * @param string $player
     * @return Move
     */
    public function setPlayer(string $player): Move
    {
        $this->player = $player;

        return $this;
    }

    /**
     * @return string
     */
    public function getGameId(): string
    {
        return $this->gameId;
    }

    /**
     * @param string $gameId
     * @return Move
     */
    public function setGameId(string $gameId): Move
    {
        $this->gameId = $gameId;

        return $this;
    }

    /**
     * @return int
     */
    public function getBoardPosition(): int
    {
        return $this->boardPosition;
    }

    /**
     * @param int $boardPosition
     * @return Move
     */
    public function setBoardPosition(int $boardPosition): Move
    {
        $this->boardPosition = $boardPosition;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Move
     */
    public function setCreatedAt(\DateTime $createdAt): Move
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
