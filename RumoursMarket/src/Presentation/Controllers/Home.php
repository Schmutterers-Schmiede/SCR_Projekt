<?php
namespace Presentation\Controllers;

class Home extends \Presentation\MVC\Controller {
public function __construct(
    private \Application\SignedInUserQuery $signedInUserQuery
)
{ }

    public function GET_Index() : \Presentation\MVC\ActionResult {
        // TODO return action result!
        return $this->view('home', [
            'user' => $this->signedInUserQuery->execute()
        ]);
    }
}