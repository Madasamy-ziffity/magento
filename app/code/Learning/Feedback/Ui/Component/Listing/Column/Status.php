<?php

namespace Learning\Feedback\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
        // print_r($dataSource['data']['items']);

           // die($dataSource['data']['items']);
            foreach ($dataSource['data']['items'] as &$items) {

                switch ($items['status']) {
                    case null:
                        $items['status'] = 'Pending';
                        break;
                    case 1:
                        $items['status'] = 'Accepted';
                        break;
                    case 0:
                        $items['status'] = 'Declined';
                        break;
                }
            }
        }
        return $dataSource;
    }

}