<?php
namespace Api\Model;

use Api\Model\Model;

class Product extends Model{

    protected $key = 'product_id';

    public function load($id = null){
        $this->setDirty(false);
        $this->data = $this->client->catalogProductInfo($id);
        return $this;
    }

    public function getStock(){

        return $this->client->catalogInventoryStockItemList(array($this->getID()));
    }

    public function getSpecialPrice(){
        return $this->client->catalogProductGetSpecialPrice($this->getID());
    }

    public function linkProduct($link){
        return $this->client->catalogProductLinkAssign($link->type,$this->product_id,$link->product_id);
    }
}