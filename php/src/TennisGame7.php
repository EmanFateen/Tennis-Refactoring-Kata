<?php

namespace TennisGame;

use TennisGame\Domain\Entity\Player;

class TennisGame7 implements TennisGame {
    private Player $firstPlayer;
    private Player $secondPlayer;

    public function __construct($player1Name, $player2Name) {
        $this->firstPlayer = new Player();
        $this->firstPlayer->setName($player1Name);

        $this->secondPlayer = new Player();
        $this->secondPlayer->setName($player2Name);
    }

    public function wonPoint($playerName): void
    {
        if ($playerName === "player1") $this->firstPlayer->incrementScore();
        if ($playerName === "player2") $this->secondPlayer->incrementScore();
    }

    public function getScore(): string
    {
        if ($this->isDeuce()) return $this->calculateDeuceScore();
        if ($this->isGameOver())  return $this->calculateEndGameScore();

        return $this->calculateNormalScore();
    }

    private function isDeuce(): bool
    {
        return $this->firstPlayer->getScore() === $this->secondPlayer->getScore();
    }

    private function calculateDeuceScore(): string
    {
        $score = match ($this->firstPlayer->getScore()) {
            0 => "Love-All",
            1 => "Fifteen-All",
            2 => "Thirty-All",
            default => "Deuce",
        };

        return $this->wrapScore($score);
    }

    private function isGameOver(): bool
    {
        return $this->firstPlayer->getScore() >= 4 || $this->secondPlayer->getScore() >= 4;
    }

    private function calculateEndGameScore(): string
    {
        if ($this->hasFirstPlayerAdvantage())
            return $this->wrapScore("Advantage " . $this->firstPlayer->getName());
        if ($this->hasSecondPlayerAdvantage())
            return $this->wrapScore("Advantage " . $this->secondPlayer->getName());

        if ($this->isFirstPlayerWon())
            return $this->wrapScore("Win for " . $this->firstPlayer->getName());
        if ($this->isSecondPlayerWon())
            return $this->wrapScore( "Win for " . $this->secondPlayer->getName());

        return "";
    }

    private function calculateNormalScore(): string
    {
        $score = match ($this->firstPlayer->getScore()) {
            0 => "Love",
            1 => "Fifteen",
            2 => "Thirty",
            default => "Forty",
        };
        $score .= "-";
        $score .= match ($this->secondPlayer->getScore()) {
            0 => "Love",
            1 => "Fifteen",
            2 => "Thirty",
            default => "Forty",
        };

        return $this->wrapScore($score);
    }

    private function hasFirstPlayerAdvantage(): bool
    {
        return $this->scoreDiff() === 1;
    }

    private function hasSecondPlayerAdvantage(): bool
    {
        return $this->scoreDiff() === -1;
    }

    private function isFirstPlayerWon(): bool
    {
        return $this->scoreDiff() >= 2;
    }

    private function isSecondPlayerWon(): bool
    {
        return $this->secondPlayer->getScore() - $this->firstPlayer->getScore() >= 2;
    }

    private function wrapScore(string $score): string
    {
        return  "Current score: ". $score . ", enjoy your game!";
    }

    private function scoreDiff(): int
    {
        return $this->firstPlayer->getScore() - $this->secondPlayer->getScore();
    }
}
