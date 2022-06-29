<?php

namespace Application;

class SignInCommand {
    public function __construct(
        private Services\AuthenticationService $authenticationService,
        private Interfaces\UserRepository $userRepository
    )
    {}

    public function execute(string $login, string $password): bool {
        $this->authenticationService->signOut();
        $user = $this->userRepository->getUserForLogin($login);
        if ($user != null && password_verify($password, $user->getPasswordHash())) {    //password_hash erstellt aus einem Password einen Hash
           $this->authenticationService->signIn($user->getid());                        //password_verify stellt ein vorheriges password_hash voraus
            return true;
        }
        return false;
    }
}