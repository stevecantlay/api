<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 19/01/2014
 * Time: 17:19
 */

namespace Api\Entity;

use Api\Hydrator\NullHydrator;

class Entity {

    protected $validation;
    protected $data;
    protected $hydrator;

    public function setMapping(){

    }

    public function getMapping(){

    }

    public function __construct(){
        $this->hydrator = new NullHydrator(array());

    }

    protected function validate($data){
        foreach($data as $property=>$value){
            if(isset($this->validation[$property])){
                $this->data[$property] = $value;
            }
        }
    }

    public function  setData($data){
        $this->data = $this->extract($data);
    }

    private function extract($data){
        return $this->hydrator->extract($data);
    }

    public function  getData(){
        return $this->data;
    }

    public function setHydrator($hydrator){
        $this->hydrator = $hydrator;
    }
} 