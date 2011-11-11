<?php

class Application_Model_RegistroMP {
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
            $this->setDbTable('Application_Model_DbTable_Registro');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Registro $model) {
        $data = array(
            'ID_TIPO_REGISTRO' =>$model->getIdTipoRegistro(),
            'ID_CATEGORIA' => $model->getIdCategoria(),
            'ID_PROYECTO' => $model->getIdProyecto(),
            'MONTO_REGISTRO' => $model->getMontoRegistro(),
            'FECHA_REGISTRO' => $model->getFechaRegistro(),
            'DESC_REGISTRO' => $model->getDescRegistro()
        );
        if ('' === ($id = $model->getIdRegistro())) {
            $data['ID_REGISTRO'] = null;
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array('ID_REGISTRO = ?' => $id));
        }
    }

    public function desactiva($id) {
        $data = array('ESTADO_REGISTRO' => 1);
        return $this->getDbTable()->update($data, array("ID_REGISTRO = ?" => $id));
    }

    public function find($id, Application_Model_Registro $data) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $data->setIdRegistro($row->ID_REGISTRO);
        $data->setIdTipoRegistro($row->ID_TIPO_REGISTRO);
        $data->setIdCategoria($row->ID_CATEGORIA);
        $data->setMontoRegistro($row->MONTO_REGISTRO);
        $data->setFechaRegistro($row->FECHA_REGISTRO);
        $data->setDescRegistro($row->DESC_REGISTRO);
        $data->setIdProyecto($row->ID_PROYECTO);
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
        $select->where("ESTADO_REGISTRO = ?", 0);
        $select->order("FECHA_REGISTRO DESC");
//        echo $select;
//        $select->limit(10,0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Registro();
            if ($attr == null) {
                $entry->setIdRegistro($row->ID_REGISTRO);
                $entry->setIdTipoRegistro($row->ID_TIPO_REGISTRO);
                $entry->setIdCategoria($row->ID_CATEGORIA);
                $entry->setIdProyecto($row->ID_PROYECTO);
                $entry->setMontoRegistro($row->MONTO_REGISTRO);
                $entry->setFechaRegistro($row->FECHA_REGISTRO);
                $entry->setDescRegistro($row->DESC_REGISTRO);
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

    public function fetchSumTipo($idTipo, $idPro, $idCat = null) {
        $select = $this->getDbTable()->select();
        $select->from('REGISTRO',array('SUM(MONTO_REGISTRO) AS TOTAL'));
        $select->where('ID_TIPO_REGISTRO = ?', $idTipo);
        $select->where('ESTADO_REGISTRO = ?', 0);
        $select->where('ID_PROYECTO = ?', $idPro);
        if($idCat != null) {
            $select->where('ID_CATEGORIA = ?', $idCat);
        }
        $res = $this->getDbTable()->fetchAll($select);
        return $res[0]->TOTAL;
    }

    public function fetchSumCat($idCat, $idTipo, $idPro) {
        $select = $this->getDbTable()->select();
        $select->from('REGISTRO',array('SUM(MONTO_REGISTRO) AS TOTAL'));
        $select->where('ID_CATEGORIA = ?', $idCat);
        $select->where('ID_TIPO_REGISTRO = ?', $idTipo);
        $select->where('ESTADO_REGISTRO = ?', 0);
        $select->where('ID_PROYECTO = ?', $idPro);
        $res = $this->getDbTable()->fetchAll($select);
        return $res[0]->TOTAL;
    }

    public function fetchByCat($idCat, $idPro, $ini, $fin) {
        $select = $this->getDbTable()->select();
        $select->from(array('R'=>'REGISTRO'), array('R.ID_TIPO_REGISTRO', 'R.ID_CATEGORIA', 'R.FECHA_REGISTRO', 'SUM(R.MONTO_REGISTRO) AS MONTO', 'DATEDIFF(\''.$fin.'\', \''.$ini.'\') AS DIAS', 'DATEDIFF(DATE(R.FECHA_REGISTRO), \''.$ini.'\') AS INDICE'));
        $select->where('R.ID_CATEGORIA = ?', $idCat);
        $select->where('R.ESTADO_REGISTRO = ?', 0);
        $select->where('R.ID_PROYECTO = ?', $idPro);
        $select->where('R.FECHA_REGISTRO >= ?', $ini);
        $select->where('R.FECHA_REGISTRO <= ?', $fin);
        $select->group("R.FECHA_REGISTRO");
        $select->order("R.FECHA_REGISTRO ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $i = 0;
        $r = "";
        foreach ($resultSet as $row) {
            if($i == 0) {
                for($i=0; $i<$row->DIAS+1; $i++) $data[$i] = 0;
                $data[$row->INDICE] = ($row->ID_TIPO_REGISTRO == 1) ? $row->MONTO : "-".$row->MONTO;
            } else {
                $data[$row->INDICE] = ($row->ID_TIPO_REGISTRO == 1) ? $row->MONTO : "-".$row->MONTO;
            }
            $i++;
        }
        $i=0;
        foreach($data as $d) {
            if($i==0) {
                $r = $d;
            } else {
                $r .= ", " . $d;
            }
            $i++;
        }
        
        return $r;
    }

    function fetchBalanceTL($idPro, $ini, $fin, $iniBal = 0) {
        $select = $this->getDbTable()->select();
        $select->from(array('R'=>'REGISTRO'), array('R.ID_TIPO_REGISTRO', 'R.ID_CATEGORIA', 'R.FECHA_REGISTRO', 'R.MONTO_REGISTRO', 'DATEDIFF(\''.$fin.'\', \''.$ini.'\') AS DIAS', 'DATEDIFF(DATE(R.FECHA_REGISTRO), \''.$ini.'\') AS INDICE'));
        $select->where('R.ESTADO_REGISTRO = ?', 0);
        $select->where('R.ID_PROYECTO = ?', $idPro);
        $select->where('R.FECHA_REGISTRO >= ?', $ini);
        $select->where('R.FECHA_REGISTRO <= ?', $fin);
        $select->order("R.FECHA_REGISTRO ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $i = 0;
        $r = "";
        $n = 0;
        foreach ($resultSet as $row) {
            if($i == 0) {
                for($i=0; $i<$row->DIAS+1; $i++) $data[$i] = 0;
                $data[$row->INDICE] += ($row->ID_TIPO_REGISTRO == 1) ? $row->MONTO_REGISTRO : -1*$row->MONTO_REGISTRO;
            } else {
                $data[$row->INDICE] += ($row->ID_TIPO_REGISTRO == 1) ? $row->MONTO_REGISTRO : -1*$row->MONTO_REGISTRO;
            }
            $i++;
        }
        $i=0;
        foreach($data as $d) {
            if($i==0) {
                $r = $iniBal + $d;
                $num = $iniBal + $d;
            } else {
                $num = $num + $d;
                $r .= ", " . $num;
            }
            $i++;
        }

        return $r;
    }

    function fetchBalanceHasta($idPro, $fin) {
        $select = $this->getDbTable()->select();
        $select->from('REGISTRO',array('SUM(MONTO_REGISTRO) AS TOTAL'));
        $select->where('ID_TIPO_REGISTRO = ?', 1);
        $select->where('ESTADO_REGISTRO = ?', 0);
        $select->where('ID_PROYECTO = ?', $idPro);
        $select->where('FECHA_REGISTRO < ?', $fin);
        $res = $this->getDbTable()->fetchAll($select);
        $ing = $res[0]->TOTAL;

        $select = $this->getDbTable()->select();
        $select->from('REGISTRO',array('SUM(MONTO_REGISTRO) AS TOTAL'));
        $select->where('ID_TIPO_REGISTRO = ?', 2);
        $select->where('ESTADO_REGISTRO = ?', 0);
        $select->where('FECHA_REGISTRO < ?', $fin);
        $select->where('ID_PROYECTO = ?', $idPro);
        $res = $this->getDbTable()->fetchAll($select);
        $egr = $res[0]->TOTAL;

        return $ing-$egr;
    }
}

