<?php

namespace TennisGame;

use TennisGame\Domain\Entity\Player;
use TennisGame\Domain\Service\ScoreCalculator;
use TennisGame\Presentation\DisplayScore;

class TennisGame7 implements TennisGame {
    private Player $firstPlayer;
    private Player $secondPlayer;
    private ScoreCalculator $scoreCalculator;
    private DisplayScore $displayScore;

    public function __construct(
        $player1Name, $player2Name,
        ?ScoreCalculator $scoreCalculator = null,
        ?DisplayScore $displayScore = null
    ) {
        $this->firstPlayer = new Player($player1Name);

        $this->secondPlayer = new Player($player2Name);

        $this->scoreCalculator = $scoreCalculator ?? new ScoreCalculator();
        $this->displayScore = $displayScore ?? new DisplayScore();
    }

    public function wonPoint(string $playerName): void
    {
        if ($playerName === $this->firstPlayer->getName()) $this->firstPlayer->incrementScore();
        if ($playerName === $this->secondPlayer->getName()) $this->secondPlayer->incrementScore();
    }

    public function getScore(): string
    {
        $score = $this->scoreCalculator->calculate($this->firstPlayer, $this->secondPlayer);

        return $this->displayScore->show($score);
    }
}
