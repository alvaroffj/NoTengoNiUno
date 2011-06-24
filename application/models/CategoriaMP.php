<?php

class Application_Model_CategoriaMP {

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
            $this->setDbTable('Application_Model_DbTable_Categoria');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Categoria $model) {
        $data = array(
            'ID_PROYECTO' => $model->getIdProyecto(),
            'CATEGORIA' => $model->getCategoria(),
            'COLOR_CATEGORIA' => $model->getColorCategoria(),
            'ESTADO_CATEGORIA' => 0
        );
//        print_r($data);

        if (null === ($id = $model->getIdCategoria())) {
            unset($data['ID_CATEGORIA']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('ID_CATEGORIA = ?' => $id));
        }
    }

    public function find($id, Application_Model_Categoria $data) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $data->setIdCategoria($row->ID_CATEGORIA);
        $data->setIdProyecto($row->ID_PROYECTO);
        $data->setCategoria($row->CATEGORIA);
        $data->setColor($row->COLOR_CATEGORIA);
        $data->setEstado($row->ESTADO_CATEGORIA);
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
            $entry = new Application_Model_Categoria();
            if ($attr == null) {
                $entry->setIdCategoria($row->ID_CATEGORIA);
                $entry->setIdProyecto($row->ID_PROYECTO);
                $entry->setCategoria($row->CATEGORIA);
                $entry->setColorCategoria($row->COLOR_CATEGORIA);
                $entry->setEstadoCategoria($row->ESTADO_CATEGORIA);
                $entry->setMonto($row->MONTO);
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

    function fetchBalance($where=null) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable());
//        $select->join(array('R' => 'REGISTRO'), 'C.ID_CATEGORIA = R.ID_CATEGORIA');
        
//        $select->where("R.ESTADO_REGISTRO = ?", 0);
//        $select->group("R.ID_CATEGORIA", "R.ID_TIPO_REGISTRO");
//        $select->order("C.ID_CATEGORIA ASC");
        if ($where != null) {
            foreach ($where as $key => $val) {
                $select->where($key . ' = ?', $val);
            }
        }
//        $sql = $select->__toString();
//        echo "$sql\n";

//        SELECT C.ID_CATEGORIA, CATEGORIA, SUM(MONTO_REGISTRO) AS MONTO, R.ID_TIPO_REGISTRO
//        FROM CATEGORIA AS C INNER JOIN REGISTRO AS R
//        WHERE R.ID_CATEGORIA = C.ID_CATEGORIA
//            AND R.ID_USUARIO = 1
//            AND R.ESTADO_REGISTRO = 0
//        GROUP BY R.ID_CATEGORIA, R.ID_TIPO_REGISTRO
//        ORDER BY C.ID_CATEGORIA
        $resultSet = $this->getDbTable()->fetchAll($select);
        $regMP = new Application_Model_RegistroMP();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Categoria();
            $entry->setIdCategoria($row->ID_CATEGORIA);
            $entry->setIdProyecto($row->ID_PROYECTO);
            $entry->setCategoria($row->CATEGORIA);
            $entry->setColorCategoria($row->COLOR_CATEGORIA);
            $entry->setEstadoCategoria($row->ESTADO_CATEGORIA);
            $entry->setIngresos($regMP->fetchSumCat($row->ID_CATEGORIA, 1, $row->ID_PROYECTO));
            $entry->setEgresos($regMP->fetchSumCat($row->ID_CATEGORIA, 2, $row->ID_PROYECTO));
            $entries[] = $entry;
        }
        return $entries;
    }
}

