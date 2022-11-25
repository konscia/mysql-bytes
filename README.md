# MySQL Bytes

🇺🇸  Little project that measures the space in disk usage of MySQL tables and databases.
It's almost an alias to few queries to better workflow on command line. 

🇧🇷  Pequeno projeto que mede o tamanho de uso de espaço em disco de tabelas e bases de dados MySQL. Este projeto é um atalho para a execução de algumas consultas SQL que facilitam o fluxo de trabalho em linha de comando.

## Config

🇺🇸  Copy the `config.php.dist` file to `config.php` and configure the database access values with some user with access to _information_schema_ database. The config is the same as [Doctrine Dbal](https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html).

## Exec

🇺🇸 To see the size of all databases greater than 1000MB use the command below: 

```bash
php give-me-database-size.php
```

🇺🇸 To see the size of ONE database and all their tables greater than 100MB use the command below:

```bash
php give-me-database-size.php database_name
```

## Notes

* The index size and data size are added to use only the total size.