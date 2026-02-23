<?php

declare(strict_types=1);

namespace TennisGame;

class TennisGame3 implements TennisGame
{
    private int $score1 = 0;
    private int $score2 = 0;
    private array $scoreTypes =  ['Love', 'Fifteen', 'Thirty', 'Forty'];

    public function __construct(
        private string $firstPlayerName,
        private string $secondPlayerName
    ) {
    }

    public function getScore(): string
    {
        if ($this->score1 < 4 && $this->score2 < 4 && !$this->totalScoreIsSix()) {
            $firstPlayerScore = $this->scoreTypes[$this->score1];
            $secondPlayerScore = $this->scoreTypes[$this->score2];

            return $this->isDeuce() ?
                "{$firstPlayerScore}-All" :
                "{$firstPlayerScore}-{$secondPlayerScore}";
        }

        if ($this->isDeuce()) return 'Deuce';


        return $this->getWinner();
    }

    public function wonPoint(string $playerName): void
    {
        if ($playerName === 'player1')  $this->score1++;
        if ($playerName === 'player2') $this->score2++;
    }

    private function isDeuce(): bool
    {
        return $this->score1 === $this->score2;
    }

    private function getWinner(): string
    {
        $winnerName = $this->score1 > $this->score2 ?
            $this->firstPlayerName :
            $this->secondPlayerName;

        return $this->isAdvantage() ?
            "Advantage {$winnerName}"
            : "Win for {$winnerName}";
    }


    private function totalScoreIsSix(): bool
    {
        return $this->score1 + $this->score2 === 6;
    }

    private function isAdvantage(): bool
    {
        return ($this->score1 - $this->score2) * ($this->score1 - $this->score2) === 1;
    }
}
