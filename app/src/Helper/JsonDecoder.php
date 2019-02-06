<?php

namespace TicTacToe\Helper;

/**
 * Class JsonDecoder
 * @package TicTacToe\Helper
 */
class JsonDecoder
{
    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public static function toArray($data): array
    {
        $data = json_decode($data, true);

        if ($data === null) {
            throw new \Exception('The Body of the request must be a json', 400);
        }

        return $data;
    }
}
