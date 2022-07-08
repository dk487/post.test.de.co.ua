<?php
declare(strict_types=1);

namespace Model;

use DateTimeInterface;
use DateTimeImmutable;
use Helper\UkrTranslit;

class Post
{
    public string $title;

    public string $content;

    public DateTimeInterface $time;

    public function __construct(
        string $title,
        string $content,
        ?DateTimeInterface $time = null
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->time = $time ?? new DateTimeImmutable();
    }
}
