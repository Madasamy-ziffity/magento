<?php

namespace Training\PluginExample\Model;

class Product
{
    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result) {
        return "GRT ".$result; // Adding Apple in product name
        //$title = $subject->getAttributeText('brand');
        //return $title.$result;
    }
}