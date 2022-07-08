<?php
declare(strict_types=1);

namespace Model;

use Model\Post;
use Helper\UkrTranslit;

class PostFile
{
    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getFileName(): string
    {
        return '_posts/'
            . $this->post->time->format('Y/Y-m-d-')
            . UkrTranslit::convertToSlug($this->post->title)
            . '.md';
    }

    public function getFileContent(): string
    {
        $date = $this->post->time->format('Y-m-d H:i:s P');
        $content = str_replace("\r", '', $this->post->content);

        return <<<MARKDOWN
---
title: {$this->post->title}
date: $date
---

$content

MARKDOWN;
    }

    public function saveFile(): bool
    {
        return !!file_put_contents(
            $this->getFileName(),
            $this->getFileContent()
        );
    }
}