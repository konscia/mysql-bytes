<?php

namespace Konscia\MysqlBytes;

class App
{
    private Database $database;
    private Cli $cli;

    public function __construct(array $config)
    {
        $this->cli = new Cli();
        $this->database = new Database($config, $this->cli);
    }

    public function getConn(): Database
    {
        return $this->database;
    }

    public function getCli(): Cli
    {
        return $this->cli;
    }

}