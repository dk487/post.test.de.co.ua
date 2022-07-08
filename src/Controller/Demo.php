<?php
declare(strict_types=1);

namespace Controller;

use Model\Post;
use Model\PostFile;

class Demo
{
    public function run(): void
    {
        $f = new PostFile(new Post($_POST['title'], $_POST['content']));

        echo '<h1>' . htmlspecialchars($f->getFileName()) . '</h1>';
        echo '<pre>' . htmlspecialchars($f->getFileContent()) . '</pre>';
    }
}
