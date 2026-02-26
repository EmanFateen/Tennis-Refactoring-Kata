<?php

namespace TennisGame;

use TennisGame\Domain\Entity\Player;
use TennisGame\Domain\Service\ScoreCalculator;

class TennisGame7 implements TennisGame {
    private Player $firstPlayer;
    private Player $secondPlayer;

    private ScoreCalculator $scoreCalculator;

    public function __construct($player1Name, $player2Name) {
        $this->firstPlayer = new Player();
        $this->firstPlayer->setName($player1Name);

        $this->secondPlayer = new Player();
        $this->secondPlayer->setName($player2Name);

        $this->scoreCalculator = new ScoreCalculator();
    }

    public function wonPoint($playerName): void
    {
        if ($playerName === "player1") $this->firstPlayer->incrementScore();
        if ($playerName === "player2") $this->secondPlayer->incrementScore();
    }

    public function getScore(): string
    {
        if ($this->isDeuce())
            return $this->wrapScore(
                $this->scoreCalculator->deuce($this->firstPlayer)
            );

        if ($this->isGameOver())
            return $this->wrapScore(
                $this->scoreCalculator->endGame($this->firstPlayer, $this->secondPlayer)
            );

        return $this->wrapScore(
            $this->scoreCalculator->normal($this->firstPlayer, $this->secondPlayer)
        );
    }

    private function isDeuce(): bool
    {
        return $this->firstPlayer->getScore() === $this->secondPlayer->getScore();
    }

    private function isGameOver(): bool
    {
        return $this->firstPlayer->getScore() >= 4 || $this->secondPlayer->getScore() >= 4;
    }


    private function wrapScore(string $score): string
    {
        return  "Current score: ". $score . ", enjoy your game!";
    }


}
