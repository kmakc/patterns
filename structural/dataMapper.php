<?php
/**
 * Преобразователь Данных — это паттерн, который выступает в роли посредника для
 * двунаправленной передачи данных между постоянным хранилищем данных (часто,
 * реляционной базы данных) и представления данных в памяти (слой домена, то что уже
 * загружено и используется для логической обработки). Цель паттерна в том, чтобы держать
 * представление данных в памяти и постоянное хранилище данных независимыми друг от друга
 * и от самого преобразователя данных. Слой состоит из одного или более mapper-а
 * (или объектов доступа к данным), отвечающих за передачу данных
 */

class User
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    public static function fromState(array $state): User
    {
        // validate state before accessing keys!

        return new self(
            $state['username'],
            $state['email']
        );
    }

    public function __construct(string $username, string $email)
    {
        // validate parameters before setting them!

        $this->username = $username;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

class UserMapper
{
    /**
     * @var StorageAdapter
     */
    private $adapter;

    /**
     * @param StorageAdapter $storage
     */
    public function __construct(StorageAdapter $storage)
    {
        $this->adapter = $storage;
    }

    /**
     * finds a user from storage based on ID and returns a User object located
     * in memory. Normally this kind of logic will be implemented using the Repository pattern.
     * However the important part is in mapRowToUser() below, that will create a business object from the
     * data fetched from storage
     *
     * @param int $id
     *
     * @return User
     */
    public function findById(int $id): User
    {
        $result = $this->adapter->find($id);

        if ($result === null) {
            throw new \InvalidArgumentException("User #$id not found");
        }

        return $this->mapRowToUser($result);
    }

    private function mapRowToUser(array $row): User
    {
        return User::fromState($row);
    }
}

class StorageAdapter
{
    /**
     * @var array
     */
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function find(int $id)
    {
        if (isset($this->data[$id])) {
            return $this->data[$id];
        }

        return null;
    }
}

//--------------------------------------------

$storage = new StorageAdapter([1 => ['username' => 'domnikl', 'email' => 'liebler.dominik@gmail.com']]);
$mapper  = new UserMapper($storage);

$user = $mapper->findById(1);
print_r($user);

/*
$storage = new StorageAdapter([]);
$mapper  = new UserMapper($storage);

$mapper->findById(1);*/