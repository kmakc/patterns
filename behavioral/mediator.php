<?php
/**
 * Шаблон "Посредник"
 * Шаблон «Посредник» подразумевает добавление стороннего объекта («посредника»)
 * для управления взаимодействием между двумя объектами («коллегами»).
 * Шаблон помогает уменьшить связанность (coupling) классов, общающихся друг с
 * другом, ведь теперь они не должны знать о реализациях своих собеседников.
 *
 * Простейший пример: чат («посредник»), в котором пользователи
 * («коллеги») отправляют друг другу сообщения.
 */

// Создадим "Посредника"
interface ChatRoomMediator
{
    public function showMessage(User $user, string $message);
}

// Посредник
class ChatRoom implements ChatRoomMediator
{
    public function showMessage(User $user, string $message)
    {
        $time = date('M d, y H:i');
        $sender = $user->getName();

        echo $time . '[' . $sender . ']:' . $message;
    }
}

// Теперь создадим коллег
class User {
    protected $name;
    protected $chatMediator;

    public function __construct(string $name, ChatRoomMediator $chatMediator) {
        $this->name = $name;
        $this->chatMediator = $chatMediator;
    }

    public function getName() {
        return $this->name;
    }

    public function send($message) {
        $this->chatMediator->showMessage($this, $message);
    }
}

//------------------------------------------------------

$mediator = new ChatRoom();

$john = new User('John Doe', $mediator);
$jane = new User('Jane Doe', $mediator);

$john->send('Hi there!');
$jane->send('Hey!');

// Выходной вид
// Feb 14, 10:58 [John]: Hi there!
// Feb 14, 10:58 [Jane]: Hey!
