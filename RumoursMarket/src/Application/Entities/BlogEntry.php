<?php

namespace Application\Entities;

class BlogEntry {
    public function __construct(
        private int $id,
        private int $userId,
        private $creationDate,
        private string $betreff,
        private string $blogText

    ) {}

    public function getId(): int { return $this->id; }

    public function getUserId() : int { return $this->userId; }

    public function getCreationDate(): string { return $this->creationDate; }

    public function getBetreff(): string { return $this->betreff; }

    public function getBlogText(): string {return $this->blogText; }
}
