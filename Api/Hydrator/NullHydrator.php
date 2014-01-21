<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 20/01/2014
 * Time: 20:35
 */

namespace Api\Hydrator;


class NullHydrator extends AbstractHydrator{

    public function extract($object)
    {
        return $object;
    }
} 