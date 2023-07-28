<?php

namespace Learning\Feedback\Controller\Adminhtml\View;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\Http;
use Learning\Feedback\Model\Feedback as Feedback;
class Review extends Action
{

    /**
     * @var PageFactory
     */
    protected $_pageFactory;
    protected $request;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $_pageFactory
     */
    public function __construct(Action\Context $context, PageFactory $_pageFactory,
      Http $request)
    {
        $this->_pageFactory = $_pageFactory;
        $this->_request = $request;
        parent::__construct($context);
    }

    /**
     * @return boolean
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Learning_Feedback::feedback');
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $result = $this->_pageFactory->create();

        $id = $this->_request->getParam('id');
       // die($id);
       
     
        $result->getConfig()->getTitle()->set('Customer Feedbacks');
        return $result;
    }

}