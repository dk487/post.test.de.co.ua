<?php
declare(strict_types=1);

namespace Helper;

use DateTimeInterface;

class GitRepo
{
    public string $dir;

    public ?string $sshKey;

    public ?string $output;

    public function __construct(string $dir, ?string $sshKey = null)
    {
        $this->dir = $dir;
        $this->sshKey = $sshKey;
    }

    public function isWritable(): bool
    {
        return is_writable($this->dir);
    }

    public function changeDir(): bool
    {
        return chdir($this->dir);
    }

    public function doPull(): bool
    {
        return $this->runCommand('git pull');
    }

    public function doCommitAll(
        string $status = 'Post from web',
        ?DateTimeInterface $dt = null
    ): bool
    {
        $gitAdd = 'git add -A';

        $gitCommit = 'git commit';
        if ($dt !== null) {
            $gitCommit .= ' -date="' . $dt->format('c') . '"';
        }
        $gitCommit .= ' -m "' . addslashes($status) . '"';

        return $this->runCommand($gitAdd)
            && $this->runCommand($gitCommit);
    }

    public function doPush(): bool
    {
        return $this->runCommand('git push');
    }

    private function runCommand(string $cmd): bool
    {
        if (!$this->isWritable()) {
            throw new \RuntimeException('Repository is not writable');
        }

        if (!$this->changeDir()) {
            throw new \RuntimeException('Cannot change dir to repository');
        }

        $cmd = $this->getEnvPrefix() . $cmd;

        ob_start();
        $result = passthru($cmd);
        $this->output = ob_get_contents();
        ob_end_clean();

        return $result === null;
    }

    private function getEnvPrefix(): string
    {
        if (is_null($this->sshKey)) {
            return '';
        }

        return 'GIT_SSH_COMMAND=\'ssh -i ' . addslashes($this->sshKey) . '\' ';
    }
}