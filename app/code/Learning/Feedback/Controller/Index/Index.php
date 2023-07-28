<?php
 
namespace Learning\Feedback\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

 
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
       /** @var ScopeConfigInterface */
       protected $scopeConfig;
    public function __construct(Context $context,PageFactory $pageFactory,ScopeConfigInterface $scopeConfig)
    {
       $this->scopeConfig = $scopeConfig;
       $this->pageFactory = $pageFactory;
       return parent::__construct($context);
    }
    public function execute()
    {
       $custom_form_page = $this->pageFactory->create();
       $custom_form_page->getConfig()->getTitle()->set(__('Feedback'));
       return $custom_form_page;
    }
}