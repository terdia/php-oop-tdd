<?php

declare(strict_types = 1);

namespace App\Database;


trait Query
{

    public function getQuery(string $type)
    {
        switch ($type){
            case self::DML_TYPE_SELECT:
                return sprintf(
                    "SELECT %s FROM %s WHERE %s",
                    $this->fields, $this->table, implode(' and ', $this->placeholders)
                );
                break;
            case self::DML_TYPE_INSERT:
                return sprintf(
                    "INSERT INTO %s (%s) VALUES (%s)",
                    $this->table, $this->fields, implode(',', $this->placeholders)
                );
                break;
            case self::DML_TYPE_UPDATE:
                return sprintf(
                    "UPDATE %s SET %s WHERE %s",
                    $this->table, implode(', ', $this->fields), implode(' and ', $this->placeholders)
                );
                break;
            case self::DML_TYPE_DELETE:
                return sprintf(
                    "DELETE FROM %s WHERE %s",
                    $this->table, implode(' and ', $this->placeholders)
                );
                break;
            default:
                throw new \InvalidArgumentException('Dml type not supported');
        }
    }
}