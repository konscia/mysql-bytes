<?php

namespace Konscia\MysqlBytes;

use League\CLImate\CLImate;

class Cli
{
    private CLImate $cli;

    public function __construct()
    {
        $this->cli = new CLImate();
        $this->cli->style->addCommand('title', ['bold', 'yellow']);
        $this->cli->style->addCommand('error', ['bold', 'red']);
        $this->cli->style->addCommand('success', ['green']);
    }

    public function title(string $str): void
    {
        $this->cli->br()->title($str);
    }

    public function error(string $str): void
    {
        $this->cli->error($str);
    }

    public function success(string $str): void
    {
        $this->cli->success($str);
    }

    public function successKeyValue(string $key, string $value): void
    {
        $this->success("{$key}: <bold>{$value}</bold>");
    }

    public function tableWithNameAndSizeInMB(array $table, int $maxSizeInMB): void
    {
        $minSizeToDisplay = $maxSizeInMB * 1024 * 1024;
        foreach ($table as $line) {
            $name = $line['name'];
            $totalSize = (int)$line['total_size_in_bytes'];
            if ($totalSize <= $minSizeToDisplay) {
                continue;
            }
            $totalSizeInMb = number_format($totalSize / 1024 / 1024, 1, '.', '_');
            $this->cli->success("{$name}: <bold>{$totalSizeInMb}MB</bold>");
        }
        $this->cli->br();
    }
}