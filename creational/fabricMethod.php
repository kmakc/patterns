<?php
/**
 * Фабричный метод
 * Порождающий шаблон проектирования, использующий генерирующие методы
 * (factory method) для решения проблемы создания объектов без указания
 * для них конкретных классов. Объекты создаются посредством вызова не
 * конструктора, а генерирующего метода, определённого в интерфейсе и
 * реализованного дочерними классами либо реализованного в базовом классе
 * и, опционально, переопределённого (overridden) производными классами (derived classes).
 */

abstract class FactoryMethod
{
    const CHEAP = 'cheap';
    const FAST  = 'fast';

    abstract protected function createVehicle(string $type): VehicleInterface;

    public function create(string $type): VehicleInterface
    {
        $obj = $this->createVehicle($type);
        $obj->setColor('black');

        return $obj;
    }
}

class ItalianFactory extends FactoryMethod
{
    protected function createVehicle(string $type): VehicleInterface
    {
        switch ($type) {
            case parent::CHEAP:
                return new Bicycle();
            case parent::FAST:
                return new CarFerrari();
            default:
                throw new \InvalidArgumentException("$type is not a valid vehicle");
        }
    }
}

class GermanFactory extends FactoryMethod
{
    protected function createVehicle(string $type): VehicleInterface
    {
        switch ($type) {
            case parent::CHEAP:
                return new Bicycle();
            case parent::FAST:
                $carMercedes = new CarMercedes();
                // we can specialize the way we want some concrete Vehicle since we know the class
                $carMercedes->addAMGTuning();

                return $carMercedes;
            default:
                throw new \InvalidArgumentException("$type is not a valid vehicle");
        }
    }
}

interface VehicleInterface
{
    public function setColor(string $rgb);
}

class CarMercedes implements VehicleInterface
{
    /**
     * @var string
     */
    private $color;

    public function setColor(string $rgb)
    {
        $this->color = $rgb;
    }

    public function addAMGTuning()
    {
        // do additional tuning here
    }
}

class CarFerrari implements VehicleInterface
{
    /**
     * @var string
     */
    private $color;

    public function setColor(string $rgb)
    {
        $this->color = $rgb;
    }
}

class Bicycle implements VehicleInterface
{
    /**
     * @var string
     */
    private $color;

    public function setColor(string $rgb)
    {
        $this->color = $rgb;
    }
}

//------------------------------------------------------

$factory = new GermanFactory();
$result  = $factory->create(FactoryMethod::CHEAP);
print_r($result);

$factory = new GermanFactory();
$result  = $factory->create(FactoryMethod::FAST);
print_r($result);

$factory = new ItalianFactory();
$result  = $factory->create(FactoryMethod::CHEAP);
print_r($result);

$factory = new ItalianFactory();
$result  = $factory->create(FactoryMethod::FAST);
print_r($result);
