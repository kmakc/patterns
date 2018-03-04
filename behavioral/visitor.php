<?php
/**
 * Посетитель — это поведенческий паттерн проектирования, который позволяет
 * создавать новые операции, не меняя классы объектов, над которыми эти
 * операции могут выполняться.
 * Шаблон «Посетитель» — это способ отделения алгоритма от структуры объекта,
 * в которой он оперирует. Результат отделения — возможность добавлять новые
 * операции в существующие структуры объектов без их модифицирования. Это один
 * из способов соблюдения принципа открытости/закрытости (open/closed principle).
 */

interface Country
{
    public function visit(Visitor $visitor);
}

interface Visitor
{
    public function visitRussia(Russia $russia);
    public function visitFrance(France $france);
}

class Russia implements Country
{
    public function drinkVodka()
    {
        echo 'drink vodka';
    }

    public function goToCremlin()
    {
        echo 'meet Putin';
    }

    public function visit(Visitor $visitor)
    {
        $visitor->visitRussia($this);
    }
}

class France implements Country
{
    public function eatBurger()
    {
        echo 'omnomnom';
    }

    public function getRest()
    {
        echo 'sleep..';
    }

    public function visit(Visitor $visitor)
    {
        $visitor->visitFrance($this);
    }
}

class Tourist implements Visitor
{
    public function visitRussia(Russia $russia)
    {
        $russia->drinkVodka();
    }

    public function visitFrance(France $france)
    {
        $france->eatBurger();
    }
}

class OldTourist implements Visitor
{
    public function visitRussia(Russia $russia)
    {
        $russia->goToCremlin();
    }

    public function visitFrance(France $france)
    {
        $france->getRest();
    }
}

$tourist = new Tourist();
$oldTourist = new OldTourist();

$russia = new Russia();
$france = new France();

$russia->visit($tourist);
$france->visit($tourist);

$russia->visit($oldTourist);
$france->visit($oldTourist);
