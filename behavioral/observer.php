<?php
/**
 * Шаблон "Наблюдатель"
 * Для реализации публикации/подписки на поведение объекта, всякий раз,
 * когда объект «Subject» меняет свое состояние, прикрепленные объекты
 * «Observers» будут уведомлены. Паттерн используется, чтобы сократить
 * количество связанных напрямую объектов и вместо этого использует слабую связь
 *
 * В шаблоне «Наблюдатель» есть объект («субъект»), ведущий список своих
 * «подчинённых» («наблюдателей») и автоматически уведомляющий их о любом
 * изменении своего состояния, обычно с помощью вызова одного из их методов.
 */

interface Observer {}
interface Observable {}

// Сначала реализуем людей, ищущих работу, которых нужно уведомлять о появлении вакансий.
class JobPost
{
    protected $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
}

class JobSeeker implements Observer
{
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function onJobPosted(JobPost $job)
    {
        // Do something with the job posting
        echo 'Hi ' . $this->name . '! New job posted: '. $job->getTitle();
    }
}

// Теперь реализуем публикации вакансий, на которые люди будут подписываться.
class JobPostings implements Observable
{
    protected $observers = [];

    protected function notify(JobPost $jobPosting)
    {
        foreach ($this->observers as $observer) {
            $observer->onJobPosted($jobPosting);
        }
    }

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function addJob(JobPost $jobPosting)
    {
        $this->notify($jobPosting);
    }
}


//------------------------------------------------------

// Создаём подписчиков
$johnDoe = new JobSeeker('John Doe');
$janeDoe = new JobSeeker('Jane Doe');

// Создаём публикатора и прикрепляем подписчиков
$jobPostings = new JobPostings();
$jobPostings->attach($johnDoe);
$jobPostings->attach($janeDoe);

// Добавляем новую вакансию и смотрим, будут ли уведомлены подписчики
$jobPostings->addJob(new JobPost('Software Engineer'));

// Output
// Hi John Doe! New job posted: Software Engineer
// Hi Jane Doe! New job posted: Software Engineer
