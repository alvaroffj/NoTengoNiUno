<?php

class Application_Model_TipoRegistroMP {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_TipoRegistro');
        }
        return $this->_dbTable;
    }

    public function find($id, Application_Model_TipoRegistro $data) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $data->setIdTipoRegistro($row->ID_TIPO_REGISTRO);
        $data->setTipoRegistro($row->TIPO_REGISTRO);
        $data->setEstado($row->ESTADO_TIPO_REGISTRO);
    }

    public function fetchAll($attr = null, $where = null) {
        $select = $this->getDbTable()->select();
        if ($attr != null) {
            $select->from($this->getDbTable(), $attr);
        } else {
            $select->from($this->getDbTable());
        }
        if ($where != null) {
            foreach ($where as $key => $val) {
                $select->where($key . ' = ?', $val);
            }
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_TipoRegistro();
            if ($attr == null) {
                $entry->setIdTipoRegistro($row->ID_TIPO_REGISTRO);
                $entry->setTipoRegistro($row->TIPO_REGISTRO);
                $entry->setEstadoTipoRegistro($row->ESTADO_TIPO_REGISTRO);
            } else {
                foreach($attr as $a) {
                    $ta = strtolower($a);
                    $ta = split("_", $ta);
                    $method = "set";
                    foreach($ta as $pa) {
                        $method .= ucfirst($pa);
                    }
                    $entry->$method($row->$a);
                }
            }
            $entries[] = $entry;
        }
        return $entries;
    }
}

