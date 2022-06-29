<?php

namespace Application\Entities;

class User {
    public function __construct(
        private int $id,
        private string $login,
        private string $userName,
        private $creationDate,
        private string $passwordHash
    )
    {
        
    }

    public function getId(): int { return $this->id; }

    public function getLogin(): string { return $this->login; }

    public function getUserName(): string { return $this->userName; }

    public function getCreationDate(): string { return $this->creationDate;}
    
    public function getPasswordHash(): string { return $this->passwordHash; }
}