<?php
/**
 * Абстрактная фабрика
 * Абстрактная фабрика - фабрика, группирующая индивидуальные, но
 * взаимосвязанные/взаимозависимые фабрики без указания для них
 * конкретных классов.
 *
 * То есть можно быть уверенными, что для каждой из фабрик
 * мы получим нужный нам набор генерирующих объекты методов
 */

interface DoorInterface
{
    public function getDescription();
}

class WoodenDoor implements DoorInterface
{
    public function getDescription()
    {
        echo 'I am a wooden door';
    }
}

class IronDoor implements DoorInterface
{
    public function getDescription()
    {
        echo 'I am an iron door';
    }
}

interface DoorFittingExpertInterface
{
    public function getDescription();
}

class Welder implements DoorFittingExpertInterface
{
    public function getDescription()
    {
        echo 'I can only fit iron doors';
    }
}

class Carpenter implements DoorFittingExpertInterface
{
    public function getDescription()
    {
        echo 'I can only fit wooden doors';
    }
}

/**
 * Фабрика деревянных дверей создаст деревянную дверь и человека
 * для её монтажа, фабрика стальных дверей — стальную дверь и соответствующего специалиста
 */
interface DoorFactoryInterface
{
    public function makeDoor(): DoorInterface;
    public function makeFittingExpert(): DoorFittingExpertInterface;
}

// Фабрика деревянных дверей возвращает плотника и деревянную дверь
class WoodenDoorFactory implements DoorFactoryInterface
{
    public function makeDoor(): DoorInterface
    {
        return new WoodenDoor();
    }

    public function makeFittingExpert(): DoorFittingExpertInterface
    {
        return new Carpenter();
    }
}

// Фабрика стальных дверей возвращает стальную дверь и сварщика
class IronDoorFactory implements DoorFactoryInterface
{
    public function makeDoor(): DoorInterface
    {
        return new IronDoor();
    }

    public function makeFittingExpert(): DoorFittingExpertInterface
    {
        return new Welder();
    }
}

//------------------------------------------------------

// Wooden Factory
$woodenFactory = new WoodenDoorFactory();
$door          = $woodenFactory->makeDoor();
$expert        = $woodenFactory->makeFittingExpert();
$door->getDescription();   // Output: Я деревянная дверь
$expert->getDescription(); // Output: Я могу устанавливать только деревянные двери

// Iron Factory
$ironFactory = new IronDoorFactory();
$door        = $ironFactory->makeDoor();
$expert      = $ironFactory->makeFittingExpert();
$door->getDescription();   // Output: Я стальная дверь
$expert->getDescription(); // Output: Я могу устанавливать только стальные двери
