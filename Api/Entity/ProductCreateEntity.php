<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 19/01/2014
 * Time: 17:22
 */

namespace Api\Entity;

use Api\Entity\Entity;


class ProductCreateEntity extends Entity{

    public $type = 'simple';
    public $sku;
    public $attributeSet;

} 