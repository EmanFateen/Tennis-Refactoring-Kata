<?php

namespace TennisGame\Domain\Entity;

class Player
{
    private string $name;
    private int $score = 0;

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function incrementScore(): void
    {
        $this->score++;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}