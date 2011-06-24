<?php

class Application_Model_UsuarioMP {

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
            $this->setDbTable('Application_Model_DbTable_Usuario');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Usuario $model) {
//        print_r($model);
        $data = array(
//            'ID_TIPO_MONEDA' => $model->getIdTipoMoneda(),
            'FECHA_SIGN' => date("Y-m-d"),
            'NOM_USUARIO' => $model->getNomUsuario(),
            'APE_USUARIO' => $model->getApeUsuario(),
            'EMA_USUARIO' => $model->getEmaUsuario(),
            'FB_ACCESS_TOKEN' => $model->getFbAccessToken(),
            'FB_SECRET' => $model->getFbSecret(),
            'FB_SESSION_KEY' => $model->getFbSessionKey(),
            'FB_SIG' => $model->getFbSig(),
            'FB_UID' => $model->getFbUid()
        );
        $us = $this->fetchByFb($model->getFbUid(), $model, array("ID_USUARIO"));
        if (null === ($id = $model->getIdUsuario())) {
//            echo "insert<br>";
            $this->getDbTable()->insert($data);
        } else {
//            echo "update<br>";
            $this->getDbTable()->update($data, array('ID_USUARIO = ?' => $id));
        }
    }

    public function fetchByFb($id, Application_Model_Usuario $data, $attr = null) {
        $select = $this->getDbTable()->select();
        if ($attr != null) {
            $select->from($this->getDbTable(), $attr);
        } else {
            $select->from($this->getDbTable());
        }
        $select->where("FB_UID = ?", $id);
        $select->limit(1,0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        foreach ($resultSet as $row) {
            if ($attr == null) {
                $data->setIdUsuario($row->ID_USUARIO);
//                $data->setIdTipoMoneda($row->ID_TIPO_MONEDA);
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

}

