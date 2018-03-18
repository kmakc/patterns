<?php
/**
 * Шаблон "Состояние"
 * Допустим, в графическом редакторе вы выбрали инструмент «Кисть».
 * Она меняет своё поведение в зависимости от настройки цвета:
 * т. е. рисует линию выбранного цвета.
 * Вкратце
 * Шаблон позволяет менять поведение класса при изменении состояния.
 * Шаблон «Состояние» реализует машину состояний объектно ориентированным
 * способом. Это достигается с помощью:
 * - реализации каждого состояния в виде производного класса интерфейса шаблона «Состояние»,
 * - реализации переходов состояний (state transitions) посредством
 * вызова методов, определённых вышестоящим классом (superclass).
 *
 * Шаблон «Состояние» — это в некотором плане шаблон «Стратегия», при котором возможно
 * переключение текущей стратегии с помощью вызова методов, определённых в интерфейсе шаблона.
 *
 * Текстовый редактор меняет состояние текста, который вы печатаете, т. е. если
 * выбрано полужирное начертание — то редактор печатает полужирным и т. д.
 */

// Сначала сделаем интерфейс состояний и сами состояния:
interface WritingState
{
    public function write(string $words);
}

class UpperCase implements WritingState
{
    public function write(string $words)
    {
        echo strtoupper($words);
    }
}

class LowerCase implements WritingState
{
    public function write(string $words)
    {
        echo strtolower($words);
    }
}


class Standart implements WritingState
{
    public function write(string $words)
    {
        echo $words;
    }
}

// Сделаем редактор:

class TextEditor
{
    protected $state;

    public function __construct(WritingState $state)
    {
        $this->state = $state;
    }

    public function setState(WritingState $state)
    {
        $this->state = $state;
    }

    public function type(string $words)
    {
        $this->state->write($words);
    }
}

//------------------------------------------------------

$editor = new TextEditor(new Standart());

$editor->type('First line');

$editor->setState(new UpperCase());

$editor->type('Second line');
$editor->type('Third line');

$editor->setState(new LowerCase());

$editor->type('Fourth line');
$editor->type('Fifth line');

// Output:
// First line
// SECOND LINE
// THIRD LINE
// fourth line
// fifth line
