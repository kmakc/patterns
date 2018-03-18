<?php
/**
 * Шаблон "Шаблонный метод"
 * Допустим, вы собрались строить дома. Этапы будут такими:
 * - Подготовка фундамента.
 * - Возведение стен.
 * - Настил крыши.
 * - Настил перекрытий.
 *
 * Порядок этапов никогда не меняется. Вы не настелите крышу до
 * возведения стен — и т. д. Но каждый этап модифицируется:
 * стены, например, можно возвести из дерева, кирпича или газобетона.
 * Вкратце
 * «Шаблонный метод» определяет каркас выполнения определённого
 * алгоритма, но реализацию самих этапов делегирует дочерним классам.
 * Википедия
 * «Шаблонный метод» — это поведенческий шаблон, определяющий основу
 * алгоритма и позволяющий наследникам переопределять некоторые шаги
 * алгоритма, не изменяя его структуру в целом.
 */

/**
 * Допустим, у нас есть программный инструмент, позволяющий тестировать, проводить
 * контроль качества кода (lint), выполнять сборку, генерировать отчёты сборки
 * (отчёты о покрытии кода, о качестве кода и т. д.), а также развёртывать приложение на тестовом сервере.
 * Сначала наш базовый класс определяет каркас алгоритма сборки.
 */
abstract class Builder
{
    // Шаблонный метод
    final public function build()
    {
        $this->test();
        $this->lint();
        $this->assemble();
        $this->deploy();
    }

    abstract public function test();
    abstract public function lint();
    abstract public function assemble();
    abstract public function deploy();
}

// Теперь создаём реализации:
class AndroidBuilder extends Builder
{
    public function test()
    {
        echo 'Running android tests';
    }

    public function lint()
    {
        echo 'Linting the android code';
    }

    public function assemble()
    {
        echo 'Assembling the android build';
    }

    public function deploy()
    {
        echo 'Deploying android build to server';
    }
}

class IosBuilder extends Builder
{
    public function test()
    {
        echo 'Running ios tests';
    }

    public function lint()
    {
        echo 'Linting the ios code';
    }

    public function assemble()
    {
        echo 'Assembling the ios build';
    }

    public function deploy()
    {
        echo 'Deploying ios build to server';
    }
}

//------------------------------------------------------

$androidBuilder = new AndroidBuilder();
$androidBuilder->build();

// Output:
// Выполнение Android-тестов
// Линтинг Android-кода
// Создание Android-сборки
// Развёртывание Android-сборки на сервере

$iosBuilder = new IosBuilder();
$iosBuilder->build();

// Output:
// Выполнение iOS-тестов
// Линтинг iOS-кода
// Создание iOS-сборки
// Развёртывание iOS-сборки на сервере