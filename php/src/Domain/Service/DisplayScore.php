<?php

namespace TennisGame\Domain\Service;

class DisplayScore
{
    public function show(string $score): string
    {
        return  "Current score: ". $score . ", enjoy your game!";
    }
}