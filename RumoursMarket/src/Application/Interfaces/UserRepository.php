<?php

namespace Application\Interfaces;

interface UserRepository {
    public function getUser(int $id): ?\Application\Entities\User; //? heißt "oder null"
    public function getUserForUserName(string $userName): ?\Application\Entities\User;
    public function getUserForLogin(string $login): ?\Application\Entities\User;
    public function addUser(string $login, string $userName, string $pwdHash): ?int;
}