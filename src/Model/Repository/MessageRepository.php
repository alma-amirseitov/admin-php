<?php

namespace App\Model\Repository;

use App\Model\Entity\Message;
//TODO сервис для отправки
include('database.php');
class MessageRepository
{
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASSWORD;
    private $dbName = DB_NAME;

    public function getAll()
    {
        $result = [];

        foreach ($this->getDB() as $messageData) {
            $result[] = new Message($messageData);
        }

        return $result;
    }

    public function create(array $messageData): Message
    {
        $this->saveDB($messageData);

        return new Message($messageData);
    }

    private function getDB(): array
    {
        $conn = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
        if ($conn == false) {
            print(mysqli_connect_error());
            return [];
        }
        mysqli_set_charset($conn, "utf8");

        $sql = 'SELECT `id`, `message` FROM `messages`';
        $result = mysqli_query($conn, $sql);
        $allAdverts = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_close($conn);
        return $allAdverts ?? [];
    }

    private function saveDB(array $data): bool
    {
        $conn = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
        if ($conn == false) {
            print(mysqli_connect_error());
            return false;
        }
        mysqli_set_charset($conn, "utf8");

        $message = $data['message'];
        $sql = 'INSERT INTO messages(`message`) VALUES ("' . $message . '")';

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            return false;
        }
        mysqli_close($conn);
        return true;
    }
}
