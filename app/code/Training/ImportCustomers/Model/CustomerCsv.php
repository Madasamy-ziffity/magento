<?php
 
namespace Training\ImportCustomers\Model;
 
use Exception;
use Generator;
use Magento\Framework\Filesystem\Io\File;
use Magento\Store\Model\StoreManagerInterface;
use Training\ImportCustomers\Model\Import\CustomerImport;
 
class CustomerCsv
{
    private $file;
    private $storeManagerInterface;
    private $customerImport;
        
    public function __construct(
        File $file,
        StoreManagerInterface $storeManagerInterface,
        CustomerImport $customerImport
    ) {
        $this->file = $file;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->customerImport = $customerImport;
    }


    public function install(string $fixture)
    {
        // get store and website ID
        $store = $this->storeManagerInterface->getStore();
        $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
        $storeId = (int) $store->getId();
    
        // read the csv header
        $header = $this->readCsvHeader($fixture)->current();
    
        // read the csv file and skip the first (header) row
        $row = $this->readCsvRows($fixture, $header);
        $row->next();
    
        // while the generator is open, read current row data, create a customer and resume the generator
        while ($row->valid()) {
            $data = $row->current();
            $this->customerImport->createCustomer($data, $websiteId, $storeId);
            $row->next();
        }
    }

    private function readCsvRows(string $file, array $header): ?Generator
    {
        $handle = fopen($file, 'rb');
    
        while (!feof($handle)) {
            $data = [];
            $rowData = fgetcsv($handle);
            if ($rowData) {
                foreach ($rowData as $key => $value) {
                    $data[$header[$key]] = $value;
                }
                yield $data;
            }
        }
    
        fclose($handle);
    }
 
    private function readCsvHeader(string $file): ?Generator
    {
        $handle = fopen($file, 'rb');
    
        while (!feof($handle)) {
            yield fgetcsv($handle);
        }
    
        fclose($handle);
    }
}