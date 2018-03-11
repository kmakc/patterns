<?php
/**
 * Простая фабрика.
 * Паттерн, в котором класс создает нужный нам объект
 *
 * Паттерн можно использовать, когда создание объекта подразумевает
 * какую-то логику. В этом случае имеет смысл делегировать задачу
 * выделенной фабрике, а не повторять повсюду один и тот же код.
 */

interface ShapeInterface
{
    public function draw();
}

class Rectangle implements ShapeInterface
{
    public function draw()
    {
        echo 'create rectangle';
    }
}

class Square implements ShapeInterface
{
    public function draw()
    {
        echo 'create square';
    }
}

class Circle implements ShapeInterface
{
    public function draw()
    {
        echo 'create circle';
    }
}

class ShapeFactory {

    public static function getShape($shape) : ShapeInterface
    {
        if ($shape === null) {
            return null;
        }
        switch ($shape) {
            case 'rectangle':
                return new Rectangle();
            case 'square':
                return new Square();
            case 'circle':
                return new Circle();
        }

        return null;
    }
}

//------------------------------------------------------

$circle = ShapeFactory::getShape('circle');
$circle->draw();
