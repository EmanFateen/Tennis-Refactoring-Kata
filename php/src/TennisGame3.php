<?php

declare(strict_types=1);

namespace TennisGame;

class TennisGame3 implements TennisGame
{
    private int $score1 = 0;
    private int $score2 = 0;
    private array $scoreTypes =  ['Love', 'Fifteen', 'Thirty', 'Forty'];

    public function __construct(
        private string $p1N,
        private string $p2N
    ) {
    }

    public function getScore(): string
    {
        if ($this->score1 < 4 && $this->score2 < 4 && ! ($this->score1 + $this->score2 === 6)) {
            $firstPlayerScore = $this->scoreTypes[$this->score1];
            $secondPlayerScore = $this->scoreTypes[$this->score2];

            return $this->isEqual() ?
                "{$firstPlayerScore}-All" :
                "{$firstPlayerScore}-{$secondPlayerScore}";
        }

        if ($this->isEqual()) return 'Deuce';


        $winnerName = $this->score1 > $this->score2 ? $this->p1N : $this->p2N;
        return (($this->score1 - $this->score2) * ($this->score1 - $this->score2) === 1) ? "Advantage {$winnerName}" : "Win for {$winnerName}";
    }

    public function wonPoint(string $playerName): void
    {
        if ($playerName === 'player1')  $this->score1++;
        if ($playerName === 'player2') $this->score2++;
    }

    private function isEqual(): bool
    {
        return $this->score1 === $this->score2;
    }
}
