<?php
declare(strict_types=1);

namespace Controller;

use Model\Post;
use Model\PostFile;
use Helper\GitRepo;

class Demo
{
    public function run(): void
    {
        $file = new PostFile(new Post($_POST['title'], $_POST['content']));
        $repo = $this->getGitRepo();

        // echo '<h1>' . htmlspecialchars($file->getFileName()) . '</h1>';
        // echo '<pre>' . htmlspecialchars($file->getFileContent()) . '</pre>';
        // return;

        $repo->doPull();
        $file->saveFile();
        $repo->doCommitAll('New post: ' . $file->post->title);
        $repo->doPush();
        echo '<h1>OK</h1>';
        echo '<pre>' . htmlspecialchars($repo->output) . '</pre>';
    }

    private function getAppRoot(): string
    {
        return dirname(dirname(__DIR__));
    }

    private function getGitRepo(): GitRepo
    {
        $dir = $this->getAppRoot() . '/var/repo';
        $sshKey = $this->getAppRoot() . '/var/ssh/post_tool';

        return new GitRepo($dir, $sshKey);
    }
}
