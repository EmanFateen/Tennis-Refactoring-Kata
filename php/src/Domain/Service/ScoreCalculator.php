<?php

namespace TennisGame\Domain\Service;

use TennisGame\Domain\Entity\Player;

class ScoreCalculator
{
    public function calculate(Player $firstPlayer, Player $secondPlayer): string
    {
        if ($this->isTie($firstPlayer, $secondPlayer))
            $score = $this->tie($firstPlayer);
        else if ($this->isGameOver($firstPlayer, $secondPlayer))
            $score = $this->gameOver($firstPlayer, $secondPlayer);
        else
            $score = $this->normal($firstPlayer, $secondPlayer);
        return $score;
    }

    private function isTie(Player $firstPlayer, Player $secondPlayer): bool
    {
        return $firstPlayer->getScore() === $secondPlayer->getScore();
    }

    private function isGameOver(Player $firstPlayer, Player $secondPlayer): bool
    {
        return $firstPlayer->getScore() >= 4 || $secondPlayer->getScore() >= 4;
    }

    private function tie(Player $player): string
    {
        return match ($player->getScore()) {
            0 => "Love-All",
            1 => "Fifteen-All",
            2 => "Thirty-All",
            default => "Deuce",
        };
    }

    private function gameOver(Player $firstPlayer, Player $secondPlayer): string
    {
        if (abs($firstPlayer->getScore() - $secondPlayer->getScore()) === 1)
            return "Advantage " . $this->getLeadingPlayer($firstPlayer, $secondPlayer);

        return ($firstPlayer->getScore() - $secondPlayer->getScore() >= 2) ?
             "Win for " . $firstPlayer->getName() :
             "Win for " . $secondPlayer->getName();

    }

    private function normal(Player $firstPlayer, Player $secondPlayer): string
    {
        $score = match ($firstPlayer->getScore()) {
            0 => "Love",
            1 => "Fifteen",
            2 => "Thirty",
            default => "Forty",
        };
        $score .= "-";
        $score .= match ($secondPlayer->getScore()) {
            0 => "Love",
            1 => "Fifteen",
            2 => "Thirty",
            default => "Forty",
        };

        return $score;
    }

    private function getLeadingPlayer(Player $firstPlayer, Player $secondPlayer): string
    {
        return $firstPlayer->getScore() - $secondPlayer->getScore() === 1 ?
            $firstPlayer->getName() :
            $secondPlayer->getName();
    }
}