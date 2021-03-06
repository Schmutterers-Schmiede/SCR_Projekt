<?php

namespace Infrastructure;

class Repository
implements
    \Application\Interfaces\BookRepository,
    \Application\Interfaces\CategoryRepository,
    \Application\Interfaces\OrderRepository,
    \Application\Interfaces\UserRepository,
    \Application\Interfaces\BlogRepository
{
    private $server;
    private $userName;
    private $password;
    private $database;

    public function __construct(string $server, string $userName, string $password, string $database)
    {
        $this->server = $server;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
    }

    // === private helper methods ===

    private function getConnection()
    {
        $con = new \mysqli($this->server, $this->userName, $this->password, $this->database);
        if (!$con) {
            die('Unable to connect to database. Error: ' . mysqli_connect_error());
        }
        return $con;
    }

    private function executeQuery($connection, $query)
    {
        $result = $connection->query($query);
        if (!$result) {
            die("Error in query '$query': " . $connection->error);
        }
        return $result;
    }

    private function executeStatement($connection, $query, $bindFunc)
    {
        $statement = $connection->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query': " . $connection->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query': " . $statement->error);
        }
        return $statement;
    }

    // === public methods ===

    public function getCategories(): array
    {
        $categories = [];
        $con = $this->getConnection();
        $res = $this->executeQuery($con, 'SELECT id, name FROM categories');
        while ($cat = $res->fetch_object()) {
            $categories[] = new \Application\Entities\Category($cat->id, $cat->name);
        }
        $res->close();
        $con->close();
        return $categories;
    }

    public function getBooksForCategory(int $categoryId): array
    {
        $books = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, title, author, price FROM books WHERE categoryId = ?',
            function ($s) use ($categoryId) {
                $s->bind_param('i', $categoryId);
            }
        );
        $stat->bind_result($id, $title, $author, $price);
        while ($stat->fetch()) {
            $books[] = new \Application\Entities\Book($id, $title, $author, $price);
        }
        $stat->close();
        $con->close();
        return $books;
    }

    public function getBooksForFilter(string $filter): array
    {
        $filter = "%$filter%";
        $books = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, title, author, price FROM books WHERE title LIKE ?',
            function ($s) use ($filter) {
                $s->bind_param('s', $filter);
            }
        );
        $stat->bind_result($id, $title, $author, $price);
        while ($stat->fetch()) {
            $books[] = new \Application\Entities\Book($id, $title, $author, $price);
        }
        $stat->close();
        $con->close();
        return $books;
    }
     
    public function getUser(int $id): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, login, userName, creationDate, passwordHash FROM users WHERE id = ?',
            function ($s) use ($id) {
                $s->bind_param('i', $id);
            }
        );
        $stat->bind_result($id, $login, $userName, $creationDate, $passwordHash);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($id, $login, $userName, $creationDate, $passwordHash);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function getUserForUserName(string $userName): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, login, userName, creationDate, passwordHash FROM users WHERE userName = ?',
            function ($s) use ($userName) {
                $s->bind_param('s', $userName);
            }
        );
        $stat->bind_result($id, $login, $userName, $creationDate, $passwordHash);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($id, $login, $userName, $creationDate, $passwordHash);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function getUserForLogin(string $login): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, login, userName, creationDate, passwordHash FROM users WHERE login = ?',
            function ($s) use ($login) {
                $s->bind_param('s', $login);
            }
        );
        $stat->bind_result($id, $login, $userName, $creationDate, $passwordHash);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($id, $login, $userName, $creationDate, $passwordHash);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function addUser(string $login, string $userName, string $pwdHash): ?int
    {
        $creationDate = date('Y-m-d H:i:s');
        $con = $this->getConnection();
        $con->autocommit(false);
        $stat = $this->executeStatement(
            $con,
            'INSERT INTO users (login, userName, creationDate, passwordHash) VALUES (?, ?, ?, ?)',
            function ($s) use ($login, $userName, $creationDate, $pwdHash) {
                $s->bind_param('ssss', $login, $userName, $creationDate, $pwdHash);
            }
        );
        $userId = $stat->insert_id;
        $stat->close();
        $con->commit();
        $con->close();
        return $userId;
    }

    public function getUsers(): array
    {
        $users = [];
        $con = $this->getConnection();
        $res = $this->executeQuery($con, 'SELECT id, login, userName, creationDate, passwordHash FROM users');
        while ($user = $res->fetch_object()) {
            $users[] = new \Application\Entities\User($user->id,$user->login,$user->userName,$user->creationDate,$user->passwordHash);
        }
        $res->close();
        $con->close();
        return $users;
    }

    public function createOrder(int $userId, array $bookIdsWithCount, string $creditCardName, string $creditCardNumber): ?int
    {
        $con = $this->getConnection();
        $con->autocommit(false);
        $stat = $this->executeStatement(
            $con,
            'INSERT INTO orders (userId, creditCardHolder, creditCardNumber) VALUES (?, ?, ?)',
            function ($s) use ($userId, $creditCardName, $creditCardNumber) {
                $s->bind_param('iss', $userId, $creditCardName, $creditCardNumber);
            }
        );
        $orderId = $stat->insert_id;
        $stat->close();
        foreach ($bookIdsWithCount as $bookId => $count) {
            for ($i = 0; $i < $count; $i++) {
                $this->executeStatement(
                    $con,
                    'INSERT INTO orderedBooks (orderId, bookId) VALUES (?, ?)',
                    function ($s) use ($orderId, $bookId) {
                        $s->bind_param('ii', $orderId, $bookId);
                    }
                )->close();
            }
        }
        $con->commit();
        $con->close();
        return $orderId;
    }

    public function getBlogsForUser(int $userId): array
    {
        $blogEntries = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, userid, datum, betreff, blogtext FROM blog WHERE userid = ? ORDER BY datum DESC',
            function ($s) use ($userId) {
                $s->bind_param('i', $userId);
            }
        );
        $stat->bind_result($id,$userid,$datum,$betreff,$blogtext);
        while ($stat->fetch()) {
            $blogEntries[] = new \Application\Entities\BlogEntry($id,$userid,$datum,$betreff,$blogtext);
        }
        $stat->close();
        $con->close();
        return $blogEntries;
    }
}
