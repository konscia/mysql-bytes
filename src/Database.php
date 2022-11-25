<?php

namespace Konscia\MysqlBytes;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class Database
{
    public function __construct(array $config, Cli $cli)
    {
        try {
            $dbalConfig = new Configuration();
            $this->conn = DriverManager::getConnection($config, $dbalConfig);
            $this->conn->connect();
        } catch (Exception $e) {
            $cli->error('Erro ao conectar com o banco de dados:');
            $cli->error($e->getMessage());
        }
    }

    public function getDatabasesList(): array
    {
        $sql = "SELECT
                    tab.table_schema AS name,	
                    SUM(data_length + index_length) AS total_size_in_bytes
                FROM information_schema.tables AS tab
                GROUP BY table_schema
                ORDER BY total_size_in_bytes DESC";
        $stmt = $this->conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function getDatabaseSize(string $databaseName): false|array
    {
        $sql = "SELECT
                    tab.table_schema AS name,	
                    SUM(data_length + index_length) AS total_size_in_bytes
                FROM information_schema.tables AS tab
                WHERE table_schema IN (:database_name)
                GROUP BY table_schema";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue("database_name", $databaseName);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAssociative();
    }

    public function getTablesSize(string $databaseName): array
    {
        $sql = "SELECT
                    tab.table_name AS name,	
                    SUM(data_length + index_length) AS total_size_in_bytes,
                    engine,
                    tab.table_schema AS 'database'
                FROM information_schema.tables AS tab
                WHERE table_schema IN (:database_name)
                  AND data_length > 0
                GROUP BY tab.table_name
                ORDER BY total_size_in_bytes DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue("database_name", $databaseName);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }
}