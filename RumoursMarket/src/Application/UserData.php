<?php

namespace Application;

class UserData
{
    public function __construct(
        private int $id,
        private string $userName,
        private $creationDate

    ) { }

    public function getId(): int { return $this->id; }

    public function getUserName(): string { return $this->userName; }

    public function getCreationDate(): string { return $this->creationDate; }
}
