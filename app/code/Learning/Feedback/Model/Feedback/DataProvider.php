<?php

namespace Learning\Feedback\Model\Feedback;

use Learning\Feedback\Model\ResourceModel\Feedback\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider {

    protected $collection;
    protected $dataPersistor;
    protected $loadedData;

    public function __construct(
    $name, $primaryFieldName, $requestFieldName, CollectionFactory $pageCollectionFactory, DataPersistorInterface $dataPersistor, \Magento\Framework\App\Filesystem\DirectoryList $directoryList, \Magento\Store\Model\StoreManagerInterface $storeManager, array $meta = [], array $data = [], PoolInterface $pool = null
    ) {
        $this->collection = $pageCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->directoryList = $directoryList;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
        $this->storeManager = $storeManager;
    }

    public function prepareMeta(array $meta) {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
       
        foreach ($items as $item) {
            $data = $item->getData();
            switch ($data['status']) {
                case null:
                    $data['status'] = 'Pending';
                    break;
                case true:
                    $data['status'] = 'Accepted';
                    break;
                case false:
                    $data['status'] = 'Declined';
                    break;
            }

            $this->_loadedData[$item->getId()] = $data;
        }
        return $this->_loadedData;
    }

}
