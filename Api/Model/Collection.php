<?php

namespace Api\Model;

use Api\Model\AbstractCollection;


class Collection extends AbstractCollection{

    protected $client;

    protected function hydrate($data){

        $entity = 'Api\Model\\' . $this->_entityClass;
        return new $entity($this->getClient(),$data);
    }

    public function setClient($client){
        $this->client = $client;
    }

    protected function getClient(){
        return $this->client;
    }

    public function current($hydrate = true)
    {
        $entity =  current($this->_entities);

        if($hydrate && $entity !== false){
            $entity = $this->hydrate($entity);
        }
        return $entity;
    }

    public function valid()
    {
        return ($this->current(false) !== false);
    }

    public function filter($filter){


        $this->_entities = array_filter($this->_entities, function ($v) use ($filter) {

            foreach($filter as $property=>$condition){
                if($v->$property != $condition){
                    return false;
                }
            }

            return $v ;
        });

        return $this;
    }
}