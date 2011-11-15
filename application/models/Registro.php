<?php

class Application_Model_Registro {
    protected $_idRegistro;
    protected $_idTipoRegistro;
    protected $_idCategoria;
    protected $_idProyecto;
    protected $_idUsuario;
    protected $_montoRegistro;
    protected $_fechaRegistro;
    protected $_descRegistro;

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

    public function getIdRegistro() {
        return $this->_idRegistro;
    }

    public function setIdRegistro($idRegistro=null) {
        $this->_idRegistro = $idRegistro;
    }

    public function getIdTipoRegistro() {
        return $this->_idTipoRegistro;
    }

    public function setIdTipoRegistro($idTipoRegistro=null) {
        $this->_idTipoRegistro = $idTipoRegistro;
    }

    public function getIdCategoria() {
        return $this->_idCategoria;
    }

    public function setIdCategoria($idCategoria=null) {
        $this->_idCategoria = $idCategoria;
    }

    public function getIdProyecto() {
        return $this->_idProyecto;
    }

    public function setIdProyecto($idProyecto=null) {
        $this->_idProyecto = $idProyecto;
    }

    public function getMontoRegistro() {
        return $this->_montoRegistro;
    }

    public function setMontoRegistro($monto=null) {
        $this->_montoRegistro = $monto;
    }

    public function getFechaRegistro() {
        return $this->_fechaRegistro;
    }

    public function setFechaRegistro($fecha=null) {
        $this->_fechaRegistro = $fecha;
    }

    public function getDescRegistro() {
        return $this->_descRegistro;
    }

    public function setDescRegistro($desc=null) {
        $this->_descRegistro = $desc;
    }
    
    public function getIdUsuario() {
        return $this->_idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->_idUsuario = $idUsuario;
    }


}
