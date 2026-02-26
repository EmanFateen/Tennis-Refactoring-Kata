<?php

namespace TennisGame;

use TennisGame\Domain\Entity\Player;
use TennisGame\Domain\Service\DisplayScore;
use TennisGame\Domain\Service\ScoreCalculator;

class TennisGame7 implements TennisGame {
    private Player $firstPlayer;
    private Player $secondPlayer;
    private ScoreCalculator $scoreCalculator;
    private DisplayScore $displayScore;

    public function __construct($player1Name, $player2Name) {
        $this->firstPlayer = new Player();
        $this->firstPlayer->setName($player1Name);

        $this->secondPlayer = new Player();
        $this->secondPlayer->setName($player2Name);

        $this->scoreCalculator = new ScoreCalculator();
        $this->displayScore = new DisplayScore();
    }

    public function wonPoint($playerName): void
    {
        if ($playerName === $this->firstPlayer->getName()) $this->firstPlayer->incrementScore();
        if ($playerName === $this->secondPlayer->getName()) $this->secondPlayer->incrementScore();
    }

    public function getScore(): string
    {
        if ($this->isDeuce())
            return $this->displayScore->show(
                $this->scoreCalculator->deuce($this->firstPlayer)
            );

        if ($this->isGameOver())
            return $this->displayScore->show(
                $this->scoreCalculator->endGame($this->firstPlayer, $this->secondPlayer)
            );

        return $this->displayScore->show(
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

}
