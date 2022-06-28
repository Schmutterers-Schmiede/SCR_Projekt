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
    const Error_PasswordEmpty = 0x02;
    const Error_PasswordNotEqual = 0x04;
    const Error_AddUserFailed = 0x10;
    public function execute(string $userName, string $pwd, string $cfpwd): int {
        $userName = trim($userName);
        $userId = null;
        $pwdHash = null;

        $errors = 0;

        if(strlen($userName)==0) {
            error_log('No Username found!',0);
            $errors |= self::Error_UserEmpty;
        }

        if(strlen($pwd)==0) {
           error_log('No Password found!',0);
           $errors |=self::Error_PasswordEmpty;
        }
     
        if($errors){
            return $errors;
        }

        if (strcmp($cfpwd,$pwd) != 0) {
            error_log('Password: ' . $pwd . ' Hash: ' . $pwdHash,0);
            error_log('Confirm:  ' . $cfpwd .' Hash ' . password_hash($cfpwd,PASSWORD_DEFAULT),0);
            error_log("Passwordhash not equal",0);
            return self::Error_PasswordNotEqual;
        }

        $pwdHash = password_hash($pwd,PASSWORD_DEFAULT);
        $userId = $this->userRepository->addUser($userName, $pwdHash);
        if($userId == null) {
            error_log("Benutzer nicht gespeichert!",0);
            return self::Error_AddUserFailed;
        }
        return 0;
    }
}
