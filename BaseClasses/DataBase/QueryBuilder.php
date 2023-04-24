<?php

namespace testFullStackDev\BaseClasses\DataBase;

use PDO;

class QueryBuilder extends DataBase
{
    /**
     * @var
     */
    protected $table;
    /**
     * @var string
     */
    protected $select = '*';
    /**
     * @var array
     */
    protected $where = [];
    /**
     * @var array
     */
    protected $bindParams = [];
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var string
     */
    protected $limit;

    /**
     * @param string $columns
     * @return $this
     */
    public function select(string $columns = '*'): QueryBuilder
    {
        $this->select = $columns;

        return $this;
    }

    /**
     * @param string $column
     * @param string $operator
     * @param $value
     * @return $this
     */
    public function where(string $column, string $operator, $value): QueryBuilder
    {
        $this->where[] = ["column" => $column, "operator" => $operator, "value" => $value];

        return $this;
    }

    /**
     * @param string $column
     * @return array|false
     */
    public function whereNull(string $column)
    {
        $query = "SELECT {$this->select} FROM {$this->table}";
        $query .= ' WHERE ' . $column . ' is NULL';
        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get()
    {
        $query = "SELECT {$this->select} FROM {$this->table}";

        if (!empty($this->where)) {
            $query .= ' WHERE ' . implode(" AND ", array_map(function ($where) {
                    return "{$where['column']} {$where['operator']} ?";
                }, $this->where));
            $this->bindParams = array_column($this->where, 'value');
        }
        if (!empty($this->limit)) {
            $query .= ' ' . $this->limit;
        }
        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute($this->bindParams);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function limit($offset, $count): QueryBuilder
    {
        $this->limit = "LIMIT $offset, $count";

        return $this;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function table(string $table): QueryBuilder
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param array $data
     * @return false|string
     */
    public function insert(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $values = array_values($data);
        $this->query($query, $values);
        return $this->lastInsertId();
    }

    /**
     * @return false|string
     */
    public function lastInsertId()
    {
        return $this->getPdo()->lastInsertId();
    }

    /**
     * @param array $data
     * @return int
     */
    public function update(array $data): int
    {
        $query = "UPDATE {$this->table} SET ";
        $values = [];

        foreach ($data as $column => $value) {
            $query .= "{$column} = ?, ";
            $values[] = $value;
        }
        $query = rtrim($query, ', ');

        if (!empty($this->where)) {
            $query .= " WHERE ";
            foreach ($this->where as $i => $where) {
                $operator = $i == 0 ? "" : "AND";
                $query .= "{$operator} {$where['column']} {$where['operator']} ?";
                $values[] = $where['value'];
            }
        }
        return $this->query($query, $values)->rowCount();
    }

    /**
     * @return int
     */
    public function delete(): int
    {
        $query = "DELETE FROM {$this->table}";
        if (!empty($this->where)) {
            $query .= " WHERE ";
            $values = [];
            foreach ($this->where as $i => $where) {
                $operator = $i == 0 ? "" : "AND";
                $query .= "{$operator} {$where['column']} {$where['operator']} ?";
                $values[] = $where['value'];
            }
            return $this->query($query, $values)->rowCount();
        }
        return 0;
    }

    /**
     * @param $perPage
     * @param $currentPage
     * @return array
     */
    public function paginate($perPage = 10, $currentPage = 1): array
    {
        $totalRows = $this->count();
        $totalPages = ceil($totalRows / $perPage);
        $offset = ($currentPage - 1) * $perPage;

        $results = $this->limit($offset, $perPage)->get();

        return [
            'data' => $results,
            'total' => $totalRows,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'last_page' => $totalPages
        ];
    }
}