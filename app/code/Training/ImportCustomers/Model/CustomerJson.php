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
    public function install(string $fixture, OutputInterface $output): void
    {
        $this->output = $output;
    
        // get store and website ID
        $store = $this->storeManagerInterface->getStore();
        $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
        $storeId = (int) $store->getId();

        $str = file_get_contents($fixture);

        $json = json_decode($str, true);
        $i=0;
        foreach ($json as $value) {
            $this->createCustomer($value, $websiteId, $storeId);
            $i++;
        }
    }

    private function createCustomer(array $data, int $websiteId, int $storeId): void
    {
      try {
          // collect the customer data
          $customerData = [
              'email'         => $data['emailaddress'],
              '_website'      => 'base',
              '_store'        => 'default',
              'confirmation'  => null,
              'dob'           => null,
              'firstname'     => $data['fname'],
              'gender'        => null,
              'lastname'      => $data['lname'],
              'middlename'    => null,
              'prefix'        => null,
              'store_id'      => $storeId,
              'website_id'    => $websiteId,
              'password'      => null,
              'disable_auto_group_change' => 0,
              'some_custom_attribute'     => 'some_custom_attribute_value'
           ];
     
          // save the customer data
          $this->customerImport->importCustomerData($customerData);
      } catch (Exception $e) {
          $this->output->writeln(
              '<error>'. $e->getMessage() .'</error>',
              OutputInterface::OUTPUT_NORMAL
          );
      }
    }
}
