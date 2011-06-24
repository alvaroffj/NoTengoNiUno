<?php

class Application_Model_DbTable_Registro extends Zend_Db_Table_Abstract {

    protected $_name = 'REGISTRO';
    protected $_primary = 'ID_REGISTRO';
    protected $_dependentTables = array('CATEGORIA');

}

