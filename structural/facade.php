<?php
/**
 * Шаблон «Фасад» предоставляет упрощённый интерфейс для сложной подсистемы.
 * Фасад не ограничевает прямого доступа к классам. Это помощник, а не ограничитель.
 * Второе - он не управляет системой в целом, только необходимой частью.
 * Если нужна одна точка управления всей системой, нужно применить паттерн фронт-контроллер (Front controller).
 * Третье. В классе, построенному по этому паттерну, не должно быть команды new.
 * Если велик соблазн инициализировать объект внутри фасада, лучше посмотреть в сторону семейства порождающих паттернов.
 *
 * Как включить компьютер? Вы скажете: «Нажать кнопку включения».
 * Это потому, что вы используете простой интерфейс, предоставляемый
 * компьютером наружу. А внутри него происходит очень много процессов.
 * Простой интерфейс для сложной подсистемы — это фасад.
 */

class Computer
{
    public function getElectricShock()
    {
        echo "Ouch!";
    }

    public function makeSound()
    {
        echo "Beep beep!";
    }

    public function showLoadingScreen()
    {
        echo "Loading..";
    }

    public function bam()
    {
        echo "Ready to be used!";
    }

    public function closeEverything()
    {
        echo "Bup bup bup buzzzz!";
    }

    public function sooth()
    {
        echo "Zzzzz";
    }

    public function pullCurrent()
    {
        echo "Haaah!";
    }
}

class ComputerFacade
{
    protected $computer;

    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
    }

    public function turnOn()
    {
        $this->computer->getElectricShock();
        $this->computer->makeSound();
        $this->computer->showLoadingScreen();
        $this->computer->bam();
    }

    public function turnOff()
    {
        $this->computer->closeEverything();
        $this->computer->pullCurrent();
        $this->computer->sooth();
    }
}

//--------------------------------------------

$computer = new ComputerFacade(new Computer());
$computer->turnOn(); // Ouch! Beep beep! Loading.. Ready to be used!
$computer->turnOff(); // Bup bup buzzz! Haah! Zzzzz
