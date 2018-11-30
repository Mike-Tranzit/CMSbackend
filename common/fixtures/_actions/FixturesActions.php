<?php
namespace common\fixtures\_actions;

trait FixturesActions
{

    public $table;
    private $_keyExist = false;

    public function load()
    {
        $this->clear();
        $this->table = $this->getTableSchema();
        foreach ($this->getData() as $alias => $row) {
            if (array_key_exists('id', $row)) $this->upsert($alias, $row);
            else $this->insert($alias, $row);
        }
    }

    public function upsert($alias, $row)
    {
        $this->_keyExist = true;
        $this->db->createCommand()->upsert($this->table->fullName, $row, $row)->execute();
        $this->data[$alias] = $row;
    }

    public function insert($alias, $row)
    {
        $primaryKeys = $this->db->schema->insert($this->table->fullName, $row);
        $this->data[$alias] = array_merge($row, $primaryKeys);
    }

    public function unload()
    {
        if ($this->_keyExist) return;
        foreach ($this->data as $alias => $row) {
            $this->db->createCommand()->delete($this->table->fullName, $row)->execute();
        }
        $this->clear();
    }

    public function clear()
    {
        $this->data = [];
    }
}
