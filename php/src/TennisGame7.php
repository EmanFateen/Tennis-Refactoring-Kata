<?php

namespace TennisGame;

class TennisGame7 implements TennisGame {
    private string $firstPlayerName;
    private string $secondPlayerName;
    private int $firstPlayerScore = 0;
    private int $secondPlayerScore = 0;

    public function __construct($player1Name, $player2Name) {
        $this->firstPlayerName = $player1Name;
        $this->secondPlayerName = $player2Name;
    }

    public function wonPoint($playerName): void
    {
        if ($playerName === "player1") $this->firstPlayerScore++;
        if ($playerName === "player2") $this->secondPlayerScore++;
    }

    public function getScore(): string
    {
        if ($this->isDeuce()) return $this->calculateDeuceScore();
        if ($this->isGameOver())  return $this->calculateEndGameScore();

        return $this->calculateNormalScore();
    }

    private function isDeuce(): bool
    {
        return $this->firstPlayerScore === $this->secondPlayerScore;
    }

    private function calculateDeuceScore(): string
    {
        $score = match ($this->firstPlayerScore) {
            0 => "Love-All",
            1 => "Fifteen-All",
            2 => "Thirty-All",
            default => "Deuce",
        };
        
        return $this->wrapScore($score);
    }

    private function isGameOver(): bool
    {
        return $this->firstPlayerScore >= 4 || $this->secondPlayerScore >= 4;
    }

    private function calculateEndGameScore(): string
    {
        if ($this->hasFirstPlayerAdvantage())
            return $this->wrapScore("Advantage " . $this->firstPlayerName);
        if ($this->hasSecondPlayerAdvantage())
            return $this->wrapScore("Advantage " . $this->secondPlayerName);

        if ($this->isFirstPlayerWon())
            return $this->wrapScore("Win for " . $this->firstPlayerName);
        if ($this->isSecondPlayerWon())
            return $this->wrapScore( "Win for " . $this->secondPlayerName);

        return "";
    }

    private function calculateNormalScore(): string
    {
        $score = match ($this->firstPlayerScore) {
            0 => "Love",
            1 => "Fifteen",
            2 => "Thirty",
            default => "Forty",
        };
        $score .= "-";
        $score .= match ($this->secondPlayerScore) {
            0 => "Love",
            1 => "Fifteen",
            2 => "Thirty",
            default => "Forty",
        };

        return $this->wrapScore($score);
    }

    private function hasFirstPlayerAdvantage(): bool
    {
        return $this->firstPlayerScore - $this->secondPlayerScore === 1;
    }

    private function hasSecondPlayerAdvantage(): bool
    {
        return $this->firstPlayerScore - $this->secondPlayerScore === -1;
    }

    private function isFirstPlayerWon(): bool
    {
        return $this->firstPlayerScore - $this->secondPlayerScore >= 2;
    }

    private function isSecondPlayerWon(): bool
    {
        return $this->secondPlayerScore - $this->firstPlayerScore >= 2;
    }

    private function wrapScore(string $score): string
    {
        return  "Current score: ". $score . ", enjoy your game!";
    }
}
