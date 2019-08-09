<?php
namespace common\fixtures\_actions;

trait FixturesActions
{

    public $table;
    private $_keyExist = false;

    public function load()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        $this->clear();
        $this->table = $this->getTableSchema();
        foreach ($this->getData() as $alias => $row) {
            if (array_key_exists('id', $row)) $this->upsert($alias, $row);
            else $this->insert($alias, $row);
        }
    }

    public function upsert($alias, $row)
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($alias, $row), false)) !== __AM_CONTINUE__) return $__am_res; 
        $this->_keyExist = true;
        $this->db->createCommand()->upsert($this->table->fullName, $row, $row)->execute();
        $this->data[$alias] = $row;
    }

    public function insert($alias, $row)
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($alias, $row), false)) !== __AM_CONTINUE__) return $__am_res; 
        $primaryKeys = $this->db->schema->insert($this->table->fullName, $row);
        $this->data[$alias] = array_merge($row, $primaryKeys);
    }

    public function unload()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 

        if ($this->_keyExist) return;
        foreach ($this->data as $alias => $row) {
            $this->db->createCommand()->delete($this->table->fullName, $row)->execute();
        }
        $this->clear();
    }

    public function clear()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        $this->data = [];
    }
}
