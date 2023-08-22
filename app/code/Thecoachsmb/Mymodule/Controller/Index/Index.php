<?php

namespace Thecoachsmb\Mymodule\Controller\Index;

use \Magento\Framework\App\Action\HttpGetActionInterface;
use \Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;

class Index extends \Magento\Framework\App\Action\Action implements HttpGetActionInterface
{
    protected $fileFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(PageFactory $resultPageFactory,
    \Magento\Framework\App\Action\Context $context,
    \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
    \Magento\Catalog\Model\ProductFactory $productFactory,
    \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
    \Magento\Framework\File\Csv $csvProcessor,
    \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
    \Magento\Catalog\Model\ResourceModel\Product $resourceProduct,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $resourceConfigurable
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resourceProduct = $resourceProduct;
        $this->resourceConfigurable = $resourceConfigurable;
        $this->fileFactory = $fileFactory;
        $this->productFactory = $productFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        parent::__construct($context);
    }

    /**
     * Prints the information
     * @return Page
     */
    public function execute()
    {
        /** Add yout header name here */
        $content[] = [
            'entity_id' => __('Entity ID'),
            'attribute_set_id' => __('Attribute Set ID'),
            'type_id' => __('Type ID'),
            'sku' => __('Sku'),
            'required_options' => __('Required Options'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
        ];

        $resultLayout = $this->resultLayoutFactory->create();
        $product = $this->productFactory->create()->getCollection();
        $collection = $this->productFactory->create()->getCollection();
        
        $fileName = 'export_product_sku.csv'; // Add Your CSV File name

        $filePath =  $this->directoryList->getPath(DirectoryList::MEDIA) . "/" . $fileName;

        while ($product = $collection->fetchItem()) {
            $content[] = [
                $product->getEntityId(),
                $product->getAttributeSetId(),
                $product->getTypeId(),
                $product->getSku(),
                $product->getRequiredOptions(),
                $product->getCreatedAt(),
                $product->getUpdatedAt()
            ];
        }
        $this->csvProcessor->setEnclosure('"')->setDelimiter(',')->saveData($filePath, $content);
        return $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename",
                'value' => $fileName,
                'rm'    => true, // True => File will be remove from directory after download.
            ],
            DirectoryList::MEDIA,
            'text/csv',
            null
        );
    }
}