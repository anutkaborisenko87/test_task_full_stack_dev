<?php

namespace testFullStackDev\BaseClasses;

class Model
{
    protected $table;
    protected $fillable = [];
    protected $primaryKey = 'id';
    protected $queryBuilder;
    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
        $this->queryBuilder->table($this->table);
    }
    public function create(array $data)
    {
        return (new QueryBuilder())->table($this->table)->insert($data);
    }
    public function update($data): int
    {
        $id = $data[$this->primaryKey];
        $columns = array_intersect_key($data, array_flip($this->fillable));
        unset($columns[$this->primaryKey]);
        return (new QueryBuilder())->table($this->table)->where($this->primaryKey, '=', $id)->update($columns);
    }
    public function delete($id): int
    {
        return $this->queryBuilder->where($this->primaryKey, '=', $id)->delete();
    }
    public function find($id)
    {
        $this->queryBuilder->where($this->primaryKey, '=', $id);
        return $this->queryBuilder->get()[0];
    }
}