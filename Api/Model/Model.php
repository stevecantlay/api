<?php
namespace Api\Model;

abstract  class Model {

    protected $client;
    protected $data;
    protected $dirty = false;
    protected $error;
    protected $key;

    public function __construct($client = null,$data = null){

        $this->client = $client;
        $this->data = $this->convert_array_to_obj($data);
    }

    public function setClient($client){
        $this->client = $client;
        return $this;
    }

    public function setData($data){
        $this->data = $this->convert_array_to_obj_recursive($data);
        return $this;
    }

    protected function setDirty($state){
        $this->dirty = $state;
    }

    public function isDirty(){
        return $this->dirty;
    }

    abstract public function load( $id = null);

    public function __get($property) {

        if ($this->hasProperty($property)) {
            if($this->isDirty()){
                $key = $this->getId();
                $this->load($key);
            }
            return $this->getProperty($property);
        }
    }

    public function __set($property,$value) {

        if ($this->hasProperty($property)) {
            $this->setProperty($property,$value);
        }
        return $this;
    }

    protected function hasProperty($property){
        if(is_object($this->data) && !empty($this->data->$property)){
            return true;
        }
        if(is_array($this->data) && !empty($this->data[$property])){
            return true;
        }
        return null;
    }

    protected function getProperty($property){
        if(is_object($this->data)){
            return $this->data->$property;
        }
        if(is_array($this->data)){
            return $this->data[$property];
        }
    }

    protected function setProperty($property,$value){
        if(is_object($this->data)){
            $this->data->$property = $value;
        }
        if(is_array($this->data)){
            $this->data[$property]  = $value;;
        }
    }

    protected function convert_array_to_obj($a) {
        if (is_array($a) ) {
            return (object) $a;
        }
        return $a;
    }

    protected function convert_object_to_array($obj) {
        if(!is_array($obj) && !is_object($obj)){
            return $obj;
        }
        if(is_object($obj)){
            $obj = get_object_vars($obj);
        }
        return array_map(array($this,__FUNCTION__), $obj);
    }

    public function toArray(){
        return $this->convert_object_to_array($this->data);
    }

    public function getId(){

        if($this->hasProperty($this->key)){
            return $this->getProperty($this->key);
        }
        return null;
    }

    protected function createCollection($data, $type){

        $collection = new Collection($data, $type);
        $collection->setClient($this->client);
        return $collection;
    }

    public function getError(){
        if($this->client->hasError()){
            return $this->client->getError();
        }
        return false;
    }

} 