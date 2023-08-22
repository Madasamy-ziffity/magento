<?php
 
namespace Training\ImportCustomers\Model\Import;
 
use Magento\CustomerImportExport\Model\Import\Customer;
use Symfony\Component\Console\Output\OutputInterface;
 
class CustomerImport extends Customer
{
    private $output;
    public function importCustomerData(array $rowData)
    {
      $this->prepareCustomerData($rowData);
      $entitiesToCreate = [];
      $entitiesToUpdate = [];
           
      $processedData = $this->_prepareDataForUpdate($rowData);
      $entitiesToCreate = array_merge($entitiesToCreate, $processedData[self::ENTITIES_TO_CREATE_KEY]);
                 
      /**
        * Save prepared data
        */
      if ($entitiesToCreate) {
          $this->_saveCustomerEntities($entitiesToCreate, $entitiesToUpdate);
      }
      return $entitiesToCreate[0]['entity_id'] ?? $entitiesToUpdate[0]['entity_id'] ?? null;
    }
    public function createCustomer(array $data, int $websiteId, int $storeId): void
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
              'disable_auto_group_change' => 0
           ];
     
          // save the customer data
          $this->importCustomerData($customerData);
      } catch (Exception $e) {
          $this->output->writeln(
              '<error>'. $e->getMessage() .'</error>',
              OutputInterface::OUTPUT_NORMAL
          );
      }
    }
}