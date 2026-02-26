<?php

namespace TennisGame;

class TennisGame7 implements TennisGame {
    private $firstPlayerName;
    private $secondPlayerName;
    private $firstPlayerScore = 0;
    private $secondPlayerScore = 0;

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
        $result = "Current score: ";

        if ($this->isDeuce()) return $this->calculateIsDeuce();

        elseif ($this->firstPlayerScore >= 4 || $this->secondPlayerScore >= 4) {
            // end-game score
            if ($this->firstPlayerScore - $this->secondPlayerScore === 1) {
                $result .= "Advantage " . $this->firstPlayerName;
            } elseif ($this->firstPlayerScore - $this->secondPlayerScore === -1) {
                $result .= "Advantage " . $this->secondPlayerName;
            } elseif ($this->firstPlayerScore - $this->secondPlayerScore >= 2) {
                $result .= "Win for " . $this->firstPlayerName;
            } else {
                $result .= "Win for " . $this->secondPlayerName;
            }
        }
        else return $this->calculateNormalScore();


        return $result . ", enjoy your game!";
    }

    private function isDeuce(): bool
    {
        return $this->firstPlayerScore === $this->secondPlayerScore;
    }

    private function calculateIsDeuce(): string
    {
        $result = "Current score: ";
        // tie score
        $result .= match ($this->firstPlayerScore) {
            0 => "Love-All",
            1 => "Fifteen-All",
            2 => "Thirty-All",
            default => "Deuce",
        };
        return $result . ", enjoy your game!";
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
}
