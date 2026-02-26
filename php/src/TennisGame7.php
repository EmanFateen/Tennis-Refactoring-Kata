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
        $result = "Current score: ";

        $result .= match ($this->firstPlayerScore) {
            0 => "Love-All",
            1 => "Fifteen-All",
            2 => "Thirty-All",
            default => "Deuce",
        };
        return $result . ", enjoy your game!";
    }

    private function isGameOver(): bool
    {
        return $this->firstPlayerScore >= 4 || $this->secondPlayerScore >= 4;
    }

    private function calculateEndGameScore(): string
    {
        $openingText = "Current score: ";
        $endingText =  ", enjoy your game!";

        if ($this->hasFirstPlayerAdvantage())
            return $openingText. "Advantage " . $this->firstPlayerName . $endingText;
        if ($this->hasSecondPlayerAdvantage())
            return $openingText. "Advantage " . $this->secondPlayerName . $endingText;

        if ($this->isFirstPlayerWon())
            return $openingText. "Win for " . $this->firstPlayerName . $endingText;
        if ($this->isSecondPlayerWon())
            return $openingText. "Win for " . $this->secondPlayerName . $endingText;

        return "";
    }

    private function calculateNormalScore(): string
    {
        $result = "Current score: ";

        $result .= match ($this->firstPlayerScore) {
            0 => "Love",
            1 => "Fifteen",
            2 => "Thirty",
            default => "Forty",
        };
        $result .= "-";
        $result .= match ($this->secondPlayerScore) {
            0 => "Love",
            1 => "Fifteen",
            2 => "Thirty",
            default => "Forty",
        };

        return $result . ", enjoy your game!";
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
}
