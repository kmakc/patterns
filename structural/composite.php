<?php
/**
 * Шаблон «Компоновщик» описывает общий порядок обработки группы объектов,
 * словно это одиночный экземпляр объекта.
 * Шаблон позволяет клиентам одинаково обращаться к отдельным объектам и к группам объектов.
 * Взаимодействие с иерархической группой объектов также, как и с отдельно взятым экземпляром.
 *
 * Пример:
 * Экземпляр класса Form обрабатывает все свои элементы формы,
 * как будто это один экземпляр. И когда вызывается метод render(),
 * он перебирает все дочерние элементы и вызывает их собственный render().
 */

interface RenderableInterface
{
    public function render(): string;
}

/**
 * The composite node MUST extend the component contract. This is mandatory for building
 * a tree of components.
 */
class Form implements RenderableInterface
{
    /**
     * @var RenderableInterface[]
     */
    private $elements;

    /**
     * runs through all elements and calls render() on them, then returns the complete representation
     * of the form.
     *
     * from the outside, one will not see this and the form will act like a single object instance
     *
     * @return string
     */
    public function render(): string
    {
        $formCode = '<form>';

        foreach ($this->elements as $element) {
            $formCode .= $element->render();
        }

        $formCode .= '</form>';

        return $formCode;
    }

    /**
     * @param RenderableInterface $element
     */
    public function addElement(RenderableInterface $element)
    {
        $this->elements[] = $element;
    }
}

class InputElement implements RenderableInterface
{
    public function render(): string
    {
        return '<input type="text" />';
    }
}

class TextElement implements RenderableInterface
{
    /**
     * @var string
     */
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function render(): string
    {
        return $this->text;
    }
}

//--------------------------------------------

$form = new Form();
$form->addElement(new TextElement('Email:'));
$form->addElement(new InputElement());
$embed = new Form();
$embed->addElement(new TextElement('Password:'));
$embed->addElement(new InputElement());
$form->addElement($embed);
echo $form->render();
