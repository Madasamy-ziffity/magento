<?php
namespace ExampleCorp\RoutingExample\Controller\Index\Index;

/**
 * Interceptor class for @see \ExampleCorp\RoutingExample\Controller\Index\Index
 */
class Interceptor extends \ExampleCorp\RoutingExample\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Framework\App\RequestInterface $request)
    {
        $this->___init();
        parent::__construct($pageFactory, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
