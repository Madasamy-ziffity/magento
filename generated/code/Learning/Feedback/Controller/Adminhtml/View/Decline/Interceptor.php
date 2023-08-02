<?php
namespace Learning\Feedback\Controller\Adminhtml\View\Decline;

/**
 * Interceptor class for @see \Learning\Feedback\Controller\Adminhtml\View\Decline
 */
class Interceptor extends \Learning\Feedback\Controller\Adminhtml\View\Decline implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Learning\Feedback\Model\FeedbackFactory $feedbackFactory, \Learning\Feedback\Helper\Sendmail $mailer)
    {
        $this->___init();
        parent::__construct($context, $feedbackFactory, $mailer);
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
