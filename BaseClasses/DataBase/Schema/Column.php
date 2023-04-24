<?php

namespace testFullStackDev\BaseClasses\DataBase\Schema;
class Column
{
    /**
     * @var
     */
    protected $name;
    /**
     * @var
     */
    protected $type;
    /**
     * @var array|mixed
     */
    protected $attributes = [];

    public function __construct(string $name, string $type, array $attributes = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->attributes = $attributes;
    }

    /**
     * @return $this
     */
    public function nullable(): Column
    {
        $this->attributes['NULL'] = true;
        return $this;
    }

    /**
     * @return void
     */
    public function unique()
    {
        $this->attributes['UNIQUE'] = true;
    }

    public function default($value): Column
    {
        $this->attributes['DEFAULT'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        $definition = "{$this->name} {$this->type}";
        foreach ($this->attributes as $attribute => $value) {
            $definition .= " {$attribute}";
            if ($value !== true) {
                $definition .= " {$value}";
            }
        }
        return $definition;
    }

}