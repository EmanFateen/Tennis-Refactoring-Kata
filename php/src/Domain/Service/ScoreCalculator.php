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
        if ($this->hasFirstPlayerAdvantage($firstPlayer, $secondPlayer))
            return "Advantage " . $firstPlayer->getName();
        if ($this->hasSecondPlayerAdvantage($firstPlayer, $secondPlayer))
            return "Advantage " . $secondPlayer->getName();

        if ($this->isFirstPlayerWon($firstPlayer, $secondPlayer))
            return "Win for " . $firstPlayer->getName();
        if ($this->isSecondPlayerWon($firstPlayer, $secondPlayer))
            return  "Win for " . $secondPlayer->getName();

        return "";
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

    private function hasFirstPlayerAdvantage(Player $firstPlayer, Player $secondPlayer): bool
    {
        return $this->scoreDiff($firstPlayer, $secondPlayer) === 1;
    }

    private function hasSecondPlayerAdvantage(Player $firstPlayer, Player $secondPlayer): bool
    {
        return $this->scoreDiff($firstPlayer, $secondPlayer) === -1;
    }

    private function isFirstPlayerWon(Player $firstPlayer, Player $secondPlayer): bool
    {
        return $this->scoreDiff($firstPlayer, $secondPlayer) >= 2;
    }

    private function isSecondPlayerWon(Player $firstPlayer, Player $secondPlayer): bool
    {
        return $secondPlayer->getScore() - $firstPlayer->getScore() >= 2;
    }

    private function scoreDiff(Player $firstPlayer, Player $secondPlayer): int
    {
        return $firstPlayer->getScore() - $secondPlayer->getScore();
    }


}