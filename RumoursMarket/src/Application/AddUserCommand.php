<?php

namespace Application;

class AddUserCommand {

  public function __construct(
        private Services\AuthenticationService $authenticationService,
        private Interfaces\UserRepository $userRepository
    )
    {
            
    }

    const Error_UserEmpty = 0x01;
    const Error_LoginEmpty = 0x02;
    const Error_PasswordEmpty = 0x04;
    const Error_PasswordNotEqual = 0x08;
    const Error_AddUserFailed = 0x10;
    public function execute(string $login, string $userName, string $pwd, string $cfpwd): int {
        $userName = trim($userName);
        $login = trim($login);
        $userId = null;
        $pwdHash = null;

        $errors = 0;

        if(strlen($login) == 0) {
            $errors |= self::Error_LoginEmpty;
        }

        if(strlen($userName) == 0) {
            $errors |= self::Error_UserEmpty;
        }

        if(strlen($pwd) == 0) {
           $errors |=self::Error_PasswordEmpty;
        }
     
        if($errors){
            return $errors;
        }

        if (strcmp($cfpwd,$pwd) != 0) {
             return self::Error_PasswordNotEqual;
        }

        $pwdHash = password_hash($pwd,PASSWORD_DEFAULT);
        $userId = $this->userRepository->addUser($login, $userName, $pwdHash);
        if($userId == null) {
            return self::Error_AddUserFailed;
        }
        return 0;
    }
}
