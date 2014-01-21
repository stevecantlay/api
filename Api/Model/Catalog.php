<?php
namespace Api\Model;

use Api\Model\Model;

class Catalog extends Model{


    public function getProducts($filter = array()){

        $products = $this->client->catalogProductList($filter);
        return $this->createCollection($products,'Product');

    }

    public function getCategoryAttributes(){

        $attributes = $this->client->catalogCategoryAttributeList();
        return $this->createCollection($attributes, 'Attribute');

    }

    public function getProductAttributeSets(){
        $attributes = $this->client->catalogProductAttributeSetList();
        return $this->createCollection($attributes,'Attribute');

    }

    public function getCategory($id){

        $categories = $this->client->catalogCategoryInfo($id);
        return new Category($this->client,$categories);
    }

    public function load($id = null){
        $this->data = $this->client->catalogCategoryTree();
        return $this;
    }

    public function deleteCategory($id){

        $this->client->catalogCategoryDelete($id);
    }

    public function getCategories($level){
        $categories = $this->client->catalogCategoryLevel();
        return $this->createCollection($categories, 'Category');
    }

    public function getStore(){

        return $this->client->catalogCategoryCurrentStore();
    }

    public function setStore($store){

        $this->client->catalogCategoryCurrentStore($store);
        return $this;
    }

    public function createProduct($product,$hydrate = true){
        $id = $this->client->catalogProductCreate($product->type,$product->attributeSet,$product->sku,$product->getData());
        if($id && $hydrate){
            return $this->getProduct($id);
        }
        return $id;
    }

    public function getProduct($id){
        $product = new Product($this->client);
        return $product->load($id);
    }

    public function deleteProduct($product,$identifierType = 'product_id'){
        return $this->client->catalogProductDelete($product->$identifierType,$identifierType);
    }

} 