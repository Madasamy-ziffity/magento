<?php
namespace Thecoachsmb\Mymodule\Controller\Index\Index;

/**
 * Interceptor class for @see \Thecoachsmb\Mymodule\Controller\Index\Index
 */
class Interceptor extends \Thecoachsmb\Mymodule\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory, \Magento\Framework\File\Csv $csvProcessor, \Magento\Framework\App\Filesystem\DirectoryList $directoryList, \Magento\Catalog\Model\ResourceModel\Product $resourceProduct, \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $resourceConfigurable)
    {
        $this->___init();
        parent::__construct($resultPageFactory, $context, $fileFactory, $productFactory, $resultLayoutFactory, $csvProcessor, $directoryList, $resourceProduct, $resourceConfigurable);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
