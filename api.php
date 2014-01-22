<?php
$pd = array(
    'categories' => array(2),
    'websites' => array(1),
    'name' => 'Product name test 3',
    'description' => 'Product description',
    'short_description' => 'Product short description',
    'weight' => '10',
    'status' => '1',
    'url_key' => 'product-url-key-test',
    'url_path' => 'product-url-path-test',
    'visibility' => '4',
    'price' => '100',
    'tax_class_id' => 1,
    'meta_title' => 'Product meta title',
    'meta_keyword' => 'Product meta keyword',
    'meta_description' => 'Product meta description'
);

$si = array(
    'qty' => 100,
    'is_in_stock' => 1
);

$pl = array(
    'type'=>'related',
    'set'=>'',
    'sku'=>'',
    'position'=>1,
    'qty'=>'10',
);



$client = new Api\Client\ApiSoapClient;

$catalog = new Api\Model\Catalog($client);

$catalog->load();

$products = $catalog->getProducts();

$category = $catalog->getCategory(8);

$productAttributeSets = $catalog->getProductAttributeSets();


$newProduct = new  Api\Entity\ProductCreateEntity();
$newInventoryStock = new  Api\Entity\StockItemUpdateEntity();
$newInventoryStock->setData($si);


$newProduct->setHydrator(new Api\Hydrator\ProductHydrator());
$newProduct->setData($pd);
$newProduct->sku = 'a new poduct to test 6';

$newProduct->attributeSet = $productAttributeSets
                                ->filter(array('name'=>'CPU'))
                                ->current()
                                ->set_id;
$newProduct->stock_data = $newInventoryStock->getData();

$product = $catalog->createProduct($newProduct);

if(!$product){
    $error = $catalog->getError();
}else{



    $product2 = new  Api\Model\Product($client);
    $product2->load(158);

    $link = new \Api\Entity\ProductLinkEntity();
    $link->setData($pl);
    $link->set = $newProduct->attributeSet;
    $link->sku = $product2->sku;
    $link->product_id = $product2->product_id;

    $r = $product->linkProduct($link);
   $r =  $catalog->deleteProduct($product,'sku');



}



$categoryProducts = $category->getProducts();

$product2 = new  Api\Model\Product($client);

$product2->load(158);

$category->setProduct($product2);

$categoryProducts = $category->getProducts();

$categoryProducts->filter(array('product_id'=>16,'type'=>'simple'));


$product = new  Api\Model\Product($client);

$product->load(166);


$cart = new Api\Model\Cart($client);

$cart->addProduct($product,2);
$products = $cart->listProducts();
$cart->total();


$product->load(166);

$product->sku = 'ramp';

$sku = $product->sku;

$p = $product->websites;

$array = $product->toArray();

$product2 = new  Api\Model\Product($client,$array);

$productStock = $product->getStock();


$catalog = new Api\Model\Catalog($client);

$catalog->load();

$products = $catalog->getProducts();

//foreach($products as $product){
//    $r = $product;
//}

$category = $catalog->getCategory(8);

$attributes = $catalog->getCategoryAttributes();

$productAttributeSets = $catalog->getProductAttributeSets();
foreach($productAttributeSets as $set){
    $r = $set;
}


function __autoload($class) {

    // convert namespace to full file path
    $class = str_replace('\\', '/', $class) . '.php';
	require_once($class);
}

