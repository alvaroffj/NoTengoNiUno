<?php

class Application_Model_DbTable_Categoria extends Zend_Db_Table_Abstract {

    protected $_name = 'CATEGORIA';
    protected $_primary = 'ID_CATEGORIA';
    protected $_dependentTables = array('REGISTRO');

}

