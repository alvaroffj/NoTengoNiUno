<?php

class Application_Model_ProyectoMP {
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
            $this->setDbTable('Application_Model_DbTable_Proyecto');
        }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_Proyecto $model) {
        $data = array(
            'ID_PROYECTO' =>$model->getIdProyecto(),
            'ID_TIPO_MONEDA' => $model->getIdTipoMoneda(),
            'NOM_PROYECTO' => $model->getNomProyecto(),
            'DESC_PROYECTO' => $model->getDescProyecto(),
            'ESTADO_PROYECTO' => $model->getEstadoProyecto()
        );
        return $this->getDbTable()->insert($data);
    }
    
    public function fetchAll($select) {
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Proyecto();
            $entry->setIdProyecto($row->ID_PROYECTO);
            $entry->setNomProyecto($row->NOM_PROYECTO);
            $entries[] = $entry;
        }
        return $entries;
    }

}

