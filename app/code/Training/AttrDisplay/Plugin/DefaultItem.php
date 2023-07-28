<?php

namespace My\Module\Plugin;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product as ProductResourceModel;
use Magento\Checkout\CustomerData\AbstractItem;
use Magento\Quote\Model\Quote\Item;

class DefaultItem
{
    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @var ProductResourceModel
     */
    private $productResourceModel;

    public function __construct(
        ProductResourceModel $productResourceModel,
        ProductFactory $productFactory
    ) {
        $this->productResourceModel = $productResourceModel;
        $this->productFactory = $productFactory;
    }

    public function aroundGetItemData(AbstractItem $subject, \Closure $proceed, Item $item)
    {
        $data = $proceed($item);

        $productId = $item->getProduct()->getEntityId();

        /** @var ProductFactory $productFactory */
        $productFactory = $this->productFactory->create();
        $this->productResourceModel->load($productFactory, $productId);
        $brandValue = $productFactory->getAttributeText('brand');

        $atts = [
            "brand" => $brandValue
        ];

        return array_merge($data, $atts);
    }
}