<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 21/01/2014
 * Time: 19:22
 */

namespace Api\Filter;


class Filter {

    protected $filter;

    public function getFilter(){
        return $this->filter;
    }

    public function setFilter(array $filter){
        $this->filter = $filter;
    }
} 