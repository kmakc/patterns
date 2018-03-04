<?php
/**
 * Шаблон «Мост» — это предпочтение компоновки наследованию.
 * Шаблон «Мост» означает отделение абстракции от реализации,
 * чтобы их обе можно было изменять независимо друг от друга.
 * Можно, использовать, если:
 * - Хотите избежать постоянной привязки реализации к абстракции (например, когда реализацию необходимо выбирать во время выполнения).
 * - Реализация и абстракция могут (или будут) дополняться через наследование
 * - Изменение на абстракции или реализации не должны сказываться на клиенте
 * - Количество классов начинает стремительно расти, не принося при этом реальной пользы
 * - Хотите повысить степень расширяемости
 * - Хотите скрыть детали реализации от клиента
 *
 * Родственным паттерном для моста является паттерн адаптер,
 * который объединяет связанные части системы и предоставляет простой интерфейс.
 * Правда мост, в отличие от адаптера, внедряется на этапе
 * проектирования, а не на готовых рабочих системах.
 */

interface FormatterInterface
{
    public function format(string $text);
}

class PlainTextFormatter implements FormatterInterface
{
    public function format(string $text)
    {
        return $text;
    }
}

class HtmlFormatter implements FormatterInterface
{
    public function format(string $text)
    {
        return sprintf('<p>!%s!</p>', $text);
    }
}

abstract class Service
{
    /**
     * @var FormatterInterface
     */
    protected $implementation;

    /**
     * @param FormatterInterface $printer
     */
    public function __construct(FormatterInterface $printer)
    {
        $this->implementation = $printer;
    }

    /**
     * @param FormatterInterface $printer
     */
    public function setImplementation(FormatterInterface $printer)
    {
        $this->implementation = $printer;
    }

    abstract public function get();
}

class HelloWorldService extends Service
{
    public function get()
    {
        return $this->implementation->format('Hello World');
    }
}

//--------------------------------------------

$service = new HelloWorldService(new PlainTextFormatter());
print_r($service->get());

// now change the implementation and use the HtmlFormatter instead
$service->setImplementation(new HtmlFormatter());
print_r($service->get());
