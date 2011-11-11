<?php

class Application_Model_UsuarioProyectoMP {
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
            $this->setDbTable('Application_Model_DbTable_UsuarioProyecto');
        }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_UsuarioProyecto $model) {
        $data = array(
            'ID_USUARIO' => $model->getIdUsuario(),
            'ID_PROYECTO' => $model->getIdProyecto(),
            'ID_NIVEL_ACCESO' => $model->getIdNivelAcceso()
        );
        
        $this->fetchUsuPro($model->getIdUsuario(), $model->getIdProyecto(), $model, array("ID_USUARIO_PROYECTO"));
        
        if (null === ($id = $model->getIdUsuarioProyecto())) {
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array('ID_USUARIO_PROYECTO = ?' => $id));
        }
    }
    
    public function fetchUsuPro($idUs, $idPro, Application_Model_UsuarioProyecto $data, $attr = null) {
        $select = $this->getDbTable()->select();
        if ($attr != null) {
            $select->from($this->getDbTable(), $attr);
        } else {
            $select->from($this->getDbTable());
        }
        $select->where('ID_USUARIO = ?', $idUs);
        $select->where('ID_PROYECTO = ?', $idPro);
        
//        echo $select->__toString();
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            if ($attr == null) {
                $data->setIdUsuarioProyecto($row->ID_USUARIO_PROYECTO);
                $data->setIdUsuario($row->ID_USUARIO);
                $data->setIdProyecto($row->ID_PROYECTO);
                $data->setIdNivelAcceso($row->ID_NIVEL_ACCESO);
            } else {
                foreach($attr as $a) {
                    $ta = strtolower($a);
                    $ta = split("_", $ta);
                    $method = "set";
                    foreach($ta as $pa) {
                        $method .= ucfirst($pa);
                    }
                    $data->$method($row->$a);
                }
            }
        }
    }
    
    public function fetchAll($select) {
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_UsuarioProyecto();
            if ($attr == null) {
                $entry->setIdUsuarioProyecto($row->ID_USUARIO_PROYECTO);
                $entry->setIdUsuario($row->ID_USUARIO);
                $entry->setIdProyecto($row->ID_PROYECTO);
                $entry->setIdNivelAcceso($row->ID_NIVEL_ACCESO);
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

