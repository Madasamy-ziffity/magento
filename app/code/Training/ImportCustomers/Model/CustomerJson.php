<?php
 
namespace Training\ImportCustomers\Model;

use Training\ImportCustomers\Model\Import\CustomerImport;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Serialize\SerializerInterface;

class CustomerJson
{
    private $customerImport;
    private $storeManagerInterface;
    private $file;
    private $serializerinterface;

    public function __construct(
        CustomerImport $customerImport,StoreManagerInterface $storeManagerInterface,File $file, SerializerInterface $serializerinterface
    ) {
        $this->customerImport = $customerImport;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->file = $file;
        $this->serializerinterface = $serializerinterface;
    }
    public function install(string $fixture)
    {
        
        // get store and website ID
        $store = $this->storeManagerInterface->getStore();
        $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
        $storeId = (int) $store->getId();

        $str = $this->file->fileGetContents($fixture);

        $json = $this->serializerinterface->unserialize($str, true);
        foreach ($json as $value) {
            $this->customerImport->createCustomer($value, $websiteId, $storeId);
        }
    }
}
