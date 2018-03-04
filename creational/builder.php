<?php
/**
 * Строитель
 * Шаблон позволяет создавать разные свойства объекта, избегая загрязнения
 * конструктора множеством входных параметров (constructor pollution). Это полезно, когда у объекта может
 * быть несколько свойств.
 *
 * Или когда создание объекта состоит из большого количества этапов.
 * Пример:
 * http://designpatternsphp.readthedocs.io/ru/latest/Creational/Builder/README.html
 * https://github.com/domnikl/DesignPatternsPHP/tree/master/Creational/Builder
 *
 * Можно использовать, когда у объекта может быть несколько свойств и когда нужно избежать Telescoping constructor.
 * Ключевое отличие от шаблона «Простая фабрика»: он используется в одноэтапном создании, а «Строитель» — в многоэтапном.
 */

class Auto
{
    protected $size;
    // доп опции
    protected $upgradeWheels = false;
    protected $upgradeDoors  = false;
    protected $upgradeLights = false;

    public function __construct(AutoConveyer $builder)
    {
        $this->upgradeWheels = $builder->upgradeWheels;
        $this->upgradeDoors  = $builder->upgradeDoors;
        $this->upgradeLights = $builder->upgradeLights;
    }
}

class AutoConveyer
{
    public $size;

    public $upgradeWheels = false;
    public $upgradeDoors  = false;
    public $upgradeLights = false;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function upgradeWheels()
    {
        $this->upgradeWheels = true;
        return $this;
    }

    public function upgradeDoors()
    {
        $this->upgradeDoors = true;
        return $this;
    }

    public function upgradeLights()
    {
        $this->upgradeLights = true;
        return $this;
    }

    public function build(): Auto
    {
        return new Auto($this);
    }
}

//------------------------------------------------------

$auto = (new AutoConveyer(100))
            ->upgradeDoors()
            ->upgradeWheels()
            ->upgradeLights()
            ->build();

var_dump($auto);
