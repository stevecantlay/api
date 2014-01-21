<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 20/01/2014
 * Time: 20:35
 */

namespace Api\Hydrator;


class ProductHydrator extends AbstractHydrator{

    protected $mapping = array(
        'categories' => 'categories',
        'websites' => 'websites',
        'name' => 'name',
        'description' => 'description',
        'short_description' => 'short_description',
        'weight' => 'weight',
        'status' => 'status',
        'url_key' => 'url_key',
        'url_path' => 'url_path',
        'visibility' => 'visibility',
        'price' => 'price',
        'tax_class_id' => 'tax_class_id',
        'meta_title' => 'meta_title',
        'meta_keyword' => 'meta_keyword',
        'meta_description' => 'meta_description'
    );

    public function extract($object)
    {
        $data = $this->mapFields($object);
        return $data;
    }
} 