<?php
namespace Api\Client;

abstract class Client {

    protected $error = null;


	public function __construct(){}
	
	public function __call($method, $args) {
		return $this->call($method,$args);
	}

    protected function setError($error){
        $this->error = $error;
    }

    public function hasError(){
        if(!empty($this->error)){
            return true;
        }

        return false;
    }
    protected function clearError(){
        $this->setError(null);
    }

    public function getError(){
        return $this->error;
    }
	abstract protected function call($method,$args);
}