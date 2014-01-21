<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 20/01/2014
 * Time: 20:35
 */

namespace Api\Hydrator;


abstract class AbstractHydrator {

    protected $mapping;

    public function __construct(){

    }

    abstract public function extract($object);

    protected function mapFields(array $array){
        foreach($this->mapping as $from => $to){
            if($to  !== $from){
                $array[$to]  = $array[$from];
                unset($array[$from]);
            }
        }
        return $array;
    }

    public function setMapping($mapping){
        $this->mapping = $mapping;
    }


} 