<?php

namespace TennisGame\Presentation;

class DisplayScore
{
    public function show(string $score): string
    {
        return  "Current score: ". $score . ", enjoy your game!";
    }
}