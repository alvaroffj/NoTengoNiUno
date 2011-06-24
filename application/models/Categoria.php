<?php

class Application_Model_Categoria {

    protected $_idCategoria;
    protected $_idProyecto;
    protected $_categoria;
    protected $_colorCategoria;
    protected $_estadoCategoria;
    protected $_ingresos;
    protected $_egresos;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value=null) {
        if ($value != null) {
            $method = 'set' . $name;
            if (('mapper' == $name) || !method_exists($this, $method)) {
                throw new Exception('Invalida propiedad de Categoria');
            }
            $this->$method($value);
        }
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalida propiedad de Categoria');
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

    public function getCategoria() {
        return $this->_categoria;
    }

    public function setCategoria($categoria=null) {
        $this->_categoria = $categoria;
    }

    public function getColorCategoria() {
        return $this->_colorCategoria;
    }

    public function setColorCategoria($color=null) {
        $this->_colorCategoria = $color;
    }

    public function getEstadoCategoria() {
        return $this->_estadoCategoria;
    }

    public function setEstadoCategoria($estado=null) {
        $this->_estadoCategoria = $estado;
    }

    public function getIngresos() {
        return $this->_ingresos;
    }

    public function setIngresos($ingresos) {
        $this->_ingresos = $ingresos;
    }

    public function getEgresos() {
        return $this->_egresos;
    }

    public function setEgresos($egresos) {
        $this->_egresos = $egresos;
    }
}

