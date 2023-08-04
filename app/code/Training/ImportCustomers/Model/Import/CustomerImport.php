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
      $entitiesToDelete = [];
      $attributesToSave = [];
     
      $processedData = $this->_prepareDataForUpdate($rowData);
      $entitiesToCreate = array_merge($entitiesToCreate, $processedData[self::ENTITIES_TO_CREATE_KEY]);
      $entitiesToUpdate = array_merge($entitiesToUpdate, $processedData[self::ENTITIES_TO_UPDATE_KEY]);
      foreach ($processedData[self::ATTRIBUTES_TO_SAVE_KEY] as $tableName => $customerAttributes) {
          if (!isset($attributesToSave[$tableName])) {
              $attributesToSave[$tableName] = [];
          }
          $attributesToSave[$tableName] = array_diff_key(
              $attributesToSave[$tableName],
              $customerAttributes
          ) + $customerAttributes;
      }
     
      $this->updateItemsCounterStats($entitiesToCreate, $entitiesToUpdate, $entitiesToDelete);
     
      /**
        * Save prepared data
        */
      if ($entitiesToCreate || $entitiesToUpdate) {
          $this->_saveCustomerEntities($entitiesToCreate, $entitiesToUpdate);
      }
      if ($attributesToSave) {
          $this->_saveCustomerAttributes($attributesToSave);
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
              'disable_auto_group_change' => 0,
              'some_custom_attribute'     => 'some_custom_attribute_value'
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