<?php
namespace Prepare\Admingrid\Controller\Adminhtml\Category\MassDelete;

/**
 * Interceptor class for @see \Prepare\Admingrid\Controller\Adminhtml\Category\MassDelete
 */
class Interceptor extends \Prepare\Admingrid\Controller\Adminhtml\Category\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository)
    {
        $this->___init();
        parent::__construct($context, $filter, $collectionFactory, $categoryRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function execute() : \Magento\Backend\Model\View\Result\Redirect
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
