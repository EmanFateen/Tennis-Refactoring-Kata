<?php

declare(strict_types=1);

namespace TennisGame;

class TennisGame3 implements TennisGame
{
    private int $firstPlayerScore = 0;
    private int $secondPlayerScore = 0;
    private array $scoreTypes =  ['Love', 'Fifteen', 'Thirty', 'Forty'];

    public function __construct(
        private string $firstPlayerName,
        private string $secondPlayerName
    ) {
    }

    public function getScore(): string
    {
        if ($this->isNormalScore()) {
            $firstPlayerScore = $this->scoreTypes[$this->firstPlayerScore];
            $secondPlayerScore = $this->scoreTypes[$this->secondPlayerScore];

            return $this->isDeuce() ?
                "{$firstPlayerScore}-All" :
                "{$firstPlayerScore}-{$secondPlayerScore}";
        }

        if ($this->isDeuce()) return 'Deuce';


        return $this->getWinner();
    }

    public function wonPoint(string $playerName): void
    {
        if ($playerName === 'player1')  $this->firstPlayerScore++;
        if ($playerName === 'player2') $this->secondPlayerScore++;
    }

    private function isNormalScore(): bool
    {
        return $this->firstPlayerScore < 4 &&
            $this->secondPlayerScore < 4 &&
            !($this->firstPlayerScore + $this->secondPlayerScore === 6);
    }

    private function isDeuce(): bool
    {
        return $this->firstPlayerScore === $this->secondPlayerScore;
    }

    private function getWinner(): string
    {
        $winnerName = $this->firstPlayerScore > $this->secondPlayerScore ?
            $this->firstPlayerName :
            $this->secondPlayerName;

        return $this->isAdvantage() ?
            "Advantage {$winnerName}"
            : "Win for {$winnerName}";
    }

    private function isAdvantage(): bool
    {
        return ($this->firstPlayerScore - $this->secondPlayerScore) * ($this->firstPlayerScore - $this->secondPlayerScore) === 1;
    }
}
