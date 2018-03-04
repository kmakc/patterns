<?php
/**
 * Приспособленец
 * Для уменьшения использования памяти Приспособленец разделяет как можно
 * больше памяти между аналогичными объектами. Это необходимо, когда используется
 * большое количество объектов, состояние которых не сильно отличается.
 * Обычной практикой является хранение состояния во внешних структурах и
 * передавать их в объект-приспособленец, когда необходимо.
 */

interface FlyweightInterface
{
    public function render(string $extrinsicState): string;
}

/**
 * Implements the flyweight interface and adds storage for intrinsic state, if any.
 * Instances of concrete flyweights are shared by means of a factory.
 */
class CharacterFlyweight implements FlyweightInterface
{
    /**
     * Any state stored by the concrete flyweight must be independent of its context.
     * For flyweights representing characters, this is usually the corresponding character code.
     *
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function render(string $font): string
    {
        // Clients supply the context-dependent information that the flyweight needs to draw itself
        // For flyweights representing characters, extrinsic state usually contains e.g. the font.

        return sprintf('Character %s with font %s', $this->name, $font);
    }
}

/**
 * A factory manages shared flyweights. Clients should not instantiate them directly,
 * but let the factory take care of returning existing objects or creating new ones.
 */
class FlyweightFactory implements \Countable
{
    /**
     * @var CharacterFlyweight[]
     */
    private $pool = [];

    public function get(string $name): CharacterFlyweight
    {
        if (!isset($this->pool[$name])) {
            $this->pool[$name] = new CharacterFlyweight($name);
        }

        return $this->pool[$name];
    }

    public function count(): int
    {
        return count($this->pool);
    }
}

//--------------------------------------------

$characters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
$fonts      = ['Arial', 'Times New Roman', 'Verdana', 'Helvetica'];
$factory    = new FlyweightFactory();

foreach ($characters as $char) {
    foreach ($fonts as $font) {
        $flyweight = $factory->get($char);
        $rendered  = $flyweight->render($font);
        var_dump($factory->count());
        var_dump($rendered);
    }
}

// Другой пример
//=============================================
/**
 * Обычно в заведениях общепита чай заваривают не отдельно для каждого клиента,
 * а сразу в некой крупной ёмкости. Это позволяет экономить ресурсы:
 * газ/электричество, время и т. д. Шаблон «Приспособленец» как раз посвящён общему использованию (sharing).
 * Шаблон применяется для минимизирования использования памяти или вычислительной стоимости
 * за счёт общего использования как можно большего количества одинаковых объектов.
 * Приспособленец — то, что будет закешировано.
 */

// Типы чая здесь — приспособленцы.
class KarakTea
{
}

// Действует как фабрика и экономит чай
class TeaMaker
{
    protected $availableTea = [];

    public function make($preference)
    {
        if (empty($this->availableTea[$preference])) {
            $this->availableTea[$preference] = new KarakTea();
        }

        return $this->availableTea[$preference];
    }
}

class TeaShop
{
    protected $orders;
    protected $teaMaker;

    public function __construct(TeaMaker $teaMaker)
    {
        $this->teaMaker = $teaMaker;
    }

    public function takeOrder(string $teaType, int $table)
    {
        $this->orders[$table] = $this->teaMaker->make($teaType);
    }

    public function serve()
    {
        foreach ($this->orders as $table => $tea) {
            echo "Serving tea to table# " . $table;
        }
    }
}

//--------------------------------------------

$teaMaker = new TeaMaker();
$shop     = new TeaShop($teaMaker);

$shop->takeOrder('less sugar', 1);
$shop->takeOrder('more milk', 2);
$shop->takeOrder('without sugar', 5);

$shop->serve();
// Serving tea to table# 1
// Serving tea to table# 2
// Serving tea to table# 5