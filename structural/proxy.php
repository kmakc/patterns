<?php
/**
 * Шаблон "Заместитель" нужен чтобы создать интерфейс взаимодействия
 * с любым классом, который трудно или невозможно использовать в оригинальном виде.
 * В наиболее общей форме «Заместитель» — это класс, функционирующий как интерфейс
 * к чему-либо. Это оболочка или объект-агент, вызываемый клиентом для получения
 * доступа к другому, «настоящему» объекту. «Заместитель» может просто переадресовывать
 * запросы настоящему объекту, а может предоставлять дополнительную логику: кеширование
 * данных при интенсивном выполнении операций или потреблении ресурсов настоящим объектом;
 * проверка предварительных условий (preconditions) до вызова выполнения операций настоящим объектом.
 */

interface Door
{
    public function open();
    public function close();
}

class LabDoor implements Door
{
    public function open()
    {
        echo "Opening lab door";
    }

    public function close()
    {
        echo "Closing the lab door";
    }
}

class Security
{
    protected $door;

    public function __construct(Door $door)
    {
        $this->door = $door;
    }

    public function open($password)
    {
        if ($this->authenticate($password)) {
            $this->door->open();
        } else {
            echo "Big no! It ain't possible.";
        }
    }

    public function authenticate($password)
    {
        return $password === '$ecr@t';
    }

    public function close()
    {
        $this->door->close();
    }
}

//--------------------------------------------

$door = new Security(new LabDoor());
$door->open('invalid'); // Big no! It ain't possible.

$door->open('$ecr@t'); // Opening lab door
$door->close(); // Closing lab door
