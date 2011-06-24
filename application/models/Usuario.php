<?php

class Application_Model_Usuario
{
    protected $_idUsuario;
    protected $_idTipoMoneda;
    protected $_fechaSign;
    protected $_nomUsuario;
    protected $_apeUsuario;
    protected $_emaUsuario;
    protected $_fbAccessToken;
    protected $_fbSecret;
    protected $_fbSessionKey;
    protected $_fbSig;
    protected $_fbUid;

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

    public function getIdUsuario() {
        return $this->_idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->_idUsuario = $idUsuario;
    }

    public function getIdTipoMoneda() {
        return $this->_idTipoMoneda;
    }

    public function setIdTipoMoneda($idTipoMoneda) {
        $this->_idTipoMoneda = $idTipoMoneda;
    }

    public function getFechaSign() {
        return $this->_fechaSign;
    }

    public function setFechaSign($fechaSign) {
        $this->_fechaSign = $fechaSign;
    }

    public function getNomUsuario() {
        return $this->_nomUsuario;
    }

    public function setNomUsuario($nomUsuario) {
        $this->_nomUsuario = $nomUsuario;
    }

    public function getApeUsuario() {
        return $this->_apeUsuario;
    }

    public function setApeUsuario($apeUsuario) {
        $this->_apeUsuario = $apeUsuario;
    }

    public function getEmaUsuario() {
        return $this->_emaUsuario;
    }

    public function setEmaUsuario($emaUsuario) {
        $this->_emaUsuario = $emaUsuario;
    }

    public function getFbAccessToken() {
        return $this->_fbAccessToken;
    }

    public function setFbAccessToken($fbAccessToken) {
        $this->_fbAccessToken = $fbAccessToken;
    }

    public function getFbSecret() {
        return $this->_fbSecret;
    }

    public function setFbSecret($fbSecret) {
        $this->_fbSecret = $fbSecret;
    }

    public function getFbSessionKey() {
        return $this->_fbSessionKey;
    }

    public function setFbSessionKey($fbSessionKey) {
        $this->_fbSessionKey = $fbSessionKey;
    }

    public function getFbSig() {
        return $this->_fbSig;
    }

    public function setFbSig($fbSig) {
        $this->_fbSig = $fbSig;
    }

    public function getFbUid() {
        return $this->_fbUid;
    }

    public function setFbUid($fbUid) {
        $this->_fbUid = $fbUid;
    }

}

