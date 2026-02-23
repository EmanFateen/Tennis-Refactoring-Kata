<?php

declare(strict_types=1);

namespace TennisGame;

class TennisGame3 implements TennisGame
{
    private int $score1 = 0;

    private int $score2 = 0;

    public function __construct(
        private string $p1N,
        private string $p2N
    ) {
    }

    public function getScore(): string
    {
        if ($this->score1 < 4 && $this->score2 < 4 && ! ($this->score1 + $this->score2 === 6)) {
            $p = ['Love', 'Fifteen', 'Thirty', 'Forty'];
            $s = $p[$this->score1];
            return ($this->score1 === $this->score2) ? "{$s}-All" : "{$s}-{$p[$this->score2]}";
        }

        if ($this->score1 === $this->score2) {
            return 'Deuce';
        }

        $s = $this->score1 > $this->score2 ? $this->p1N : $this->p2N;
        return (($this->score1 - $this->score2) * ($this->score1 - $this->score2) === 1) ? "Advantage {$s}" : "Win for {$s}";
    }

    public function wonPoint(string $playerName): void
    {
        if ($playerName === 'player1')  $this->score1++;
        if ($playerName === 'player2') $this->score2++;
    }
}
