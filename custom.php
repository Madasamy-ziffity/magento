<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '5G');
error_reporting(E_ALL);

use Magento\Framework\App\Bootstrap;
require realpath(__DIR__) . '/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$registry = $objectManager->get('Magento\Framework\Registry');
$registry->register('isSecureArea', true);
//Store id of exported products, This is useful when we have multiple stores. 

$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

/** @var MagentoCatalogModelResourceModelProductCollection $productCollection */
$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
$collection = $productCollection->addAttributeToSelect('*')->load();

$fp = fopen('exports.csv', 'w');
$csvHeader = array("name","sku");
$i = 0;

fputcsv( $fp, $csvHeader,",");
foreach ($collection as $product){
    $data = array(); 
    $data[] = $product->getName(); 
    $data[] = $product->getSku();
    fputcsv($fp, $data);	
}

fclose($fp);
echo 'export all product';
?>