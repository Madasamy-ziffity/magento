<?php
 
namespace Training\ImportCustomers\Model;

use Training\ImportCustomers\Model\Import\CustomerImport;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Serialize\SerializerInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CustomerJson
{
    private $customerImport;
    private $storeManagerInterface;
    private $file;
    private $serializerInterface;

    public function __construct(CustomerImport $customerImport,StoreManagerInterface $storeManagerInterface,File $file, SerializerInterface $serializerInterface
    ) {
        $this->customerImport = $customerImport;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->file = $file;
        $this->serializerInterface = $serializerInterface;
    }
     /**
     * @param string $fixture
     * @param OutputInterface $output
     * @return void
     *
     */
    public function install(string $fixture,OutputInterface $output)
    {
        // get store and website ID
        $store = $this->storeManagerInterface->getStore();
        $websiteId = $this->storeManagerInterface->getWebsite()->getId();
        $storeId = $store->getId();
        $str = $this->file->fileGetContents($fixture);
        $json = $this->serializerInterface->unserialize($str, true);
        foreach ($json as $value) {
            $this->customerImport->createCustomer($value, $websiteId, $storeId,$output);
        }
    }
}
