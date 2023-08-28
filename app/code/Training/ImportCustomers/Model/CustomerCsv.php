<?php
 
namespace Training\ImportCustomers\Model;
 
use Magento\Store\Model\StoreManagerInterface;
use Training\ImportCustomers\Model\Import\CustomerImport;
use Magento\Framework\File\Csv;
use Symfony\Component\Console\Output\OutputInterface;
 
class CustomerCsv
{
    private $storeManagerInterface;
    private $customerImport;
    private $csvParser;
        
    public function __construct(
        StoreManagerInterface $storeManagerInterface,
        CustomerImport $customerImport,
        Csv $csvParser
    ) {
        $this->storeManagerInterface = $storeManagerInterface;
        $this->customerImport = $customerImport;
        $this->csvParser = $csvParser;
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
        $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
        $storeId = (int) $store->getId();
    
        $this->readCsvRows($fixture,$websiteId,$storeId,$output);
    }
    /**
     * @param string $fixture
     * @param int $websiteId
     * @param int $storeId
     * @param OutputInterface $output
     * @return void
     *
     */
    private function readCsvRows(string $fixture,int $websiteId, int $storeId,OutputInterface $output)
    {
        $data = [];
        $contents = $this->csvParser->getData($fixture);
        $headers = !empty($contents) ? $contents[0] : [];
        foreach ($contents as $row => $values) {
        if ($row > 0) {
            foreach ($values as $key => $value) {
                $data[$headers[$key]] = $value;
            }
            $this->customerImport->createCustomer($data, $websiteId, $storeId,$output);
        }
        }
    }
 }