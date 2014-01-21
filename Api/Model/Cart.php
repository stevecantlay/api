<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 16/01/2014
 * Time: 21:51
 */

namespace Api\Model;

use Api\Model\Model;

class Cart extends Model{

    protected $customer;
    protected $paymentMethod;
    protected $incrementId;
    protected $products;
    protected $totals;

    protected $key = 'quote_id';


    public function __construct($client = null,$data = null){

        $this->setClient($client);
        $cart = $this->client->shoppingCartCreate();
        $this->load($cart);
    }

    public function load($id = null){
        $this->setDirty(false);
        $this->data = $this->client->shoppingCartInfo($id);
        return $this;
    }

    protected function getTotals(){

        $this->totals = $this->client->shoppingCartTotals($this->quote_id);
    }

    public function createOrder(){

        $incrementId = $this->client->shoppingCartOrder($this->quote_id);
        return $incrementId;
    }

    public function addProduct($product, $qty){

        $success = $this->client->shoppingCartProductAdd(
            $this->quote_id,
            array(
                array(
                'product_id' => $product->product_id,
                'sku' => $product->sku,
                'qty' => $qty,
                'options' => null,
                'bundle_option' => null,
                'bundle_option_qty' => null,
                'links' => null
                )
            )
        );
        $this->load($this->quote_id);
        $this->setDirty(true);
        return $success;
    }

    public function total(){

        $this->getTotals();
    }

    public function listProducts(){

        $products = $this->client->shoppingCartProductList($this->quote_id);

        return $this->createCollection($products,'Product');
    }
} 