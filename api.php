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

$client = new Api\Client\ApiSoapClient;

$catalog = new Api\Model\Catalog($client);

$catalog->load();

$products = $catalog->getProducts();

$category = $catalog->getCategory(8);

$productAttributeSets = $catalog->getProductAttributeSets();


$newProduct = new  Api\Entity\ProductCreateEntity();

$newProduct->setHydrator(new Api\Hydrator\ProductHydrator());
$newProduct->setData($pd);
$newProduct->sku = 'a new poduct to test 4';

$newProduct->attributeSet = $productAttributeSets
                                ->filter(array('name'=>'CPU'))
                                ->current()
                                ->set_id;

$product = $catalog->createProduct($newProduct);

if(!$product){
    $error = $catalog->getError();
}else{
   $r =  $catalog->deleteProduct($product,'sku');
}



$categoryProducts = $category->getProducts();

$product = new  Api\Model\Product($client);

$product->load(158);

$category->setProduct($product);

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

