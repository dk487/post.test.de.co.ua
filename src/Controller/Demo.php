<?php
declare(strict_types=1);

namespace Controller;

use Helper\UkrainianTransliteration;

class Demo
{
    public function run()
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $time = time();

        $t = new UkrainianTransliteration();
        $slug = $t->convertToSlug($_POST['title']);
        $filename = '_posts/' . date('Y/Y-m-d-', $time) . $slug . '.md';
        $date = date('Y-m-d H:i:s P', $time);

        $md = <<<MARKDOWN
---
title: $title
date: $date
---

$content

MARKDOWN;

        //chdir(__DIR__ . '/repo');
        //if (!file_put_contents($filename, $md)) {
        //  echo '<h1>Error: cannot write</p>';
        //  die();
        //}
        //echo '<h1>OK</h1>';

        echo '<h1>' . htmlspecialchars($filename) . '</h1>';
        echo '<pre>' . htmlspecialchars($md) . '</pre>';
    }
}
