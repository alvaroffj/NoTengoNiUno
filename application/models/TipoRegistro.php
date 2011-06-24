<?php

class Application_Model_TipoRegistro {
    protected $_idTipoRegistro;
    protected $_tipoRegistro;
    protected $_estadoTipoRegistro;

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

    public function getIdTipoRegistro() {
        return $this->_idTipoRegistro;
    }

    public function setIdTipoRegistro($idTipoRegistro) {
        $this->_idTipoRegistro = $idTipoRegistro;
    }

    public function getTipoRegistro() {
        return $this->_tipoRegistro;
    }

    public function setTipoRegistro($tipoRegistro) {
        $this->_tipoRegistro = $tipoRegistro;
    }

    public function getEstadoTipoRegistro() {
        return $this->_estadoTipoRegistro;
    }

    public function setEstadoTipoRegistro($estado) {
        $this->_estadoTipoRegistro = $estado;
    }
}

