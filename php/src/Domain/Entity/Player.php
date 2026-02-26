<?php

namespace TennisGame\Domain\Entity;

class Player
{
    private string $name;
    private Score $score;

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}