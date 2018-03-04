<?php
/**
 * Прототип
 * Шаблон «Прототип» используется, когда типы создаваемых объектов
 * определяются экземпляром-прототипом, клонированным для создания
 * новых объектов. То есть шаблон позволяет дублировать существующий
 * объект и модифицировать копию в соответствии с потребностями.
 * Без заморочек созданием объекта с нуля и его настройкой.
 * Также для модификации процедуры клонирования можно обратиться к магическому методу __clone.
 *
 * Когда использовать?
 * Когда необходимый объект аналогичен уже существующему или когда создание с нуля дороже клонирования.
 */

class Sheep
{
    protected $name;
    protected $category;

    public function __construct(string $name, string $category = 'Mountain Sheep')
    {
        $this->name     = $name;
        $this->category = $category;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCategory(string $category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }
}

//------------------------------------------------------

$original = new Sheep('Jolly');
echo $original->getName();     // Джолли
echo $original->getCategory(); // Горная овечка

// Клонируйте и модифицируйте, что нужно
$cloned = clone $original;
$cloned->setName('Dolly');
echo $cloned->getName();     // Долли
echo $cloned->getCategory(); // Горная овечка
