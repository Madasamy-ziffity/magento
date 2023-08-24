<?php
 
namespace Training\ImportCustomers\Model;
 
use Exception;
use Generator;
use Magento\Framework\Filesystem\Io\File;
use Magento\Store\Model\StoreManagerInterface;
use Training\ImportCustomers\Model\Import\CustomerImport;
use Magento\Framework\File\Csv;
 
class CustomerCsv
{
    private $file;
    private $storeManagerInterface;
    private $customerImport;
    private $csvParser;
        
    public function __construct(
        File $file,
        StoreManagerInterface $storeManagerInterface,
        CustomerImport $customerImport,
        Csv $csvParser
    ) {
        $this->file = $file;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->customerImport = $customerImport;
        $this->csvParser = $csvParser;
    }

    /**
     * @param string $fixture
     *
     * @return null
     *
     */
    public function install(string $fixture)
    {
        // get store and website ID
        $store = $this->storeManagerInterface->getStore();
        $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
        $storeId = (int) $store->getId();
    
        $this->readCsvRows($fixture,$websiteId,$storeId);
    }
    /**
     * @param string $file
     * @param int $websiteId,$storeId
     *
     * @return null
     *
     */
    private function readCsvRows(string $file,int $websiteId, int $storeId)
    {
        $data = [];
        $contents = $this->csvParser->getData($file);
        $headers = !empty($contents) ? $contents[0] : [];
        foreach ($contents as $row => $values) {
        if ($row > 0) {
            foreach ($values as $key => $value) {
                $data[$headers[$key]] = $value;
            }
            $this->customerImport->createCustomer($data, $websiteId, $storeId);
        }
        }
    }
 }