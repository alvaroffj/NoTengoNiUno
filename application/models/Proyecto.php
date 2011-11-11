<?php

class Application_Model_Proyecto {
    protected $_idProyecto;
    protected $_idTipoMoneda;
    protected $_nomProyecto;
    protected $_descProyecto;
    protected $_estadoProyecto;
    
    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalida propiedad de Registro');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalida propiedad de Registro');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function getIdProyecto() {
        return $this->_idProyecto;
    }

    public function setIdProyecto($idProyecto=null) {
        $this->_idProyecto = $idProyecto;
    }

    public function getIdTipoMoneda() {
        return $this->_idTipoMoneda;
    }

    public function setIdTipoMoneda($idTipoMoneda=null) {
        $this->_idTipoMoneda = $idTipoMoneda;
    }

    public function getNomProyecto() {
        return $this->_nomProyecto;
    }

    public function setNomProyecto($nomProyecto=null) {
        $this->_nomProyecto = $nomProyecto;
    }

    public function getDescProyecto() {
        return $this->_descProyecto;
    }

    public function setDescProyecto($descProyecto=null) {
        $this->_descProyecto = $descProyecto;
    }
    
    public function getEstadoProyecto() {
        return $this->_estadoProyecto;
    }

    public function setEstadoProyecto($estadoProyecto=null) {
        $this->_estadoProyecto = $estadoProyecto;
    }
}

