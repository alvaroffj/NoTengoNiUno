<?php

class Application_Model_UsuarioProyecto {
    protected $_idUsuarioProyecto;
    protected $_idUsuario;
    protected $_idProyecto;
    protected $_idNivelAcceso;
    
    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalida propiedad de usuarioProyecto');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalida propiedad de usuarioProyecto');
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

    public function getIdUsuarioProyecto() {
        return $this->_idUsuarioProyecto;
    }

    public function setIdUsuarioProyecto($idUsuarioProyecto=null) {
        $this->_idUsuarioProyecto = $idUsuarioProyecto;
    }

    public function getIdUsuario() {
        return $this->_idUsuario;
    }

    public function setIdUsuario($idUsuario=null) {
        $this->_idUsuario = $idUsuario;
    }

    public function getIdProyecto() {
        return $this->_idProyecto;
    }

    public function setIdProyecto($idProyecto=null) {
        $this->_idProyecto = $idProyecto;
    }

    public function getIdNivelAcceso() {
        return $this->_idNivelAcceso;
    }

    public function setIdNivelAcceso($idNivelAcceso=null) {
        $this->_idNivelAcceso = $idNivelAcceso;
    }
}

