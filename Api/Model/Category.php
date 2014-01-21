<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 16/01/2014
 * Time: 21:20
 */

namespace Api\Model;

use Api\Model\Model;

class Category extends Model {

    protected $key = 'category_id';

    public function load($id = null){

        $this->setDirty(false);
        $this->data = $this->client->catalogCategoryInfo($id);
        return $this;
    }

    public function getProducts(){

        $products = $this->client->catalogCategoryAssignedProducts($this->getId());
        return $this->createCollection($products,'Product');
    }

    public function setProduct($product, $position = false){

        $this->client->catalogCategoryAssignProduct(
            $this->getId(),
            $product->product_id,
            $position
            );
        $this->setDirty(true);
    }

    public function removeProduct($product){

        $this->client->catalogCategoryRemoveProduct($this->getId(),$product->product_id);
        $this->setDirty(true);
        return $this;
    }

    public function updateProductPosition($product, $position){

        $this->client->catalogCategoryUpdateProduct($this->getId(),$product->product_id,$position);
        $this->setDirty(true);
        return $this;
    }

    public function move($newParent){

        $this->client->catalogCategoryMove ($this->getId(),$newParent->category_id);
        $this->setDirty(true);
        return $this;
    }

    public function update(array $data = array()){

        if(empty($data) && $this->isDirty()){
            $this->client->catalogCategoryUpdate($this->getId(),$this->toArray());
        }
        $this->client->catalogCategoryUpdate($this->getId(),$data);
        $this->setDirty(true);
        return $this;
    }
} 