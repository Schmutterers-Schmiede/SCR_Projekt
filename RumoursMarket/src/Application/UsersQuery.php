<?php

namespace Application;

class UsersQuery {
    public function __construct(
        private \Application\Interfaces\UserRepository $userRepository
        
    ) {}

    public function execute () : array {
        $users = $this->userRepository->getUsers();
        $res = [];
        foreach($users as $u ) {
            $res[] = new UserData ($u->getId(),$u->getUserName(),$u->getCreationDate());
        }
        return $res;
    }
}