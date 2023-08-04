<?php
 
namespace Training\ImportCustomers\Model;

use Training\ImportCustomers\Model\Import\CustomerImport;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Store\Model\StoreManagerInterface;

class CustomerJson
{
    private $customerImport;
    private $output;
    private $storeManagerInterface;

    public function __construct(
        CustomerImport $customerImport,StoreManagerInterface $storeManagerInterface
    ) {
        $this->customerImport = $customerImport;
        $this->storeManagerInterface = $storeManagerInterface;
    }
    public function install(string $fixture, OutputInterface $output)
    {
        $this->output = $output;
    
        // get store and website ID
        $store = $this->storeManagerInterface->getStore();
        $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
        $storeId = (int) $store->getId();

        $str = file_get_contents($fixture);

        $json = json_decode($str, true);
        foreach ($json as $value) {
            $this->customerImport->createCustomer($value, $websiteId, $storeId);
        }
    }
}
