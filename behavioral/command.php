<?php
/**
 * Шаблон "Команда"
 * Допустим, у нас есть объекты Invoker (Командир) и Receiver (Исполнитель).
 * Этот паттерн использует реализацию интерфейса «Команда», чтобы вызвать некий
 * метод Исполнителя используя для этого известный Командиру метод «execute()».
 * Командир просто знает, что нужно вызвать метод “execute()”, для обработки команды
 * клиента, не разбираясь в деталях реализации Исполнителя. Исполнитель отделен от Командира.
 *
 * Вы пришли в ресторан. Вы (Client) просите официанта (Invoker) принести блюда (Command).
 * Официант перенаправляет запрос шеф-повару (Receiver), который знает, что и как готовить.
 * Другой пример: вы (Client) включаете (Command) телевизор (Receiver) с помощью пульта (Invoker).
 */

// Receiver
class Bulb
{
    public function turnOn()
    {
        echo "Bulb has been lit";
    }

    public function turnOff()
    {
        echo "Darkness!";
    }
}

// Теперь сделаем интерфейс, который будет реализовывать каждая команда. Также сделаем набор команд.
interface Command
{
    public function execute();
    public function undo();
    public function redo();
}

// Command
class TurnOn implements Command
{
    protected $bulb;

    public function __construct(Bulb $bulb)
    {
        $this->bulb = $bulb;
    }

    public function execute()
    {
        $this->bulb->turnOn();
    }

    public function undo()
    {
        $this->bulb->turnOff();
    }

    public function redo()
    {
        $this->execute();
    }
}

class TurnOff implements Command
{
    protected $bulb;

    public function __construct(Bulb $bulb)
    {
        $this->bulb = $bulb;
    }

    public function execute()
    {
        $this->bulb->turnOff();
    }

    public function undo()
    {
        $this->bulb->turnOn();
    }

    public function redo()
    {
        $this->execute();
    }
}

// Теперь сделаем вызывающего Invoker, с которым будет взаимодействовать клиент для обработки команд.
// Invoker
class RemoteControl
{
    public function submit(Command $command)
    {
        $command->execute();
    }
}

//------------------------------------------------------

$bulb    = new Bulb();

$turnOn  = new TurnOn($bulb);
$turnOff = new TurnOff($bulb);

$remote = new RemoteControl();
$remote->submit($turnOn);     // Лампочка зажглась!
$remote->submit($turnOff);    // Темнота!
