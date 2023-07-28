<?php
namespace Learning\Feedback\Controller\Index;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Learning\Feedback\Model\FeedbackFactory;
use Magento\Framework\Controller\ResultFactory;

class Submit extends Action\Action
{
    /** @var PageFactory */
    protected $_pageFactory;

    /** @var FeedbackFactory */
    protected $_feedbackFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        FeedbackFactory $feedbackFactory
       
    )
    {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
        $this->_feedbackFactory = $feedbackFactory;
    }


    public function execute()
    {

        try {
            $post   = (array) $this->getRequest()->getPost();
            if ($post) {
                $form = $this->_feedbackFactory->create();
                $form->addData($post)->save();
                $this->messageManager->addSuccessMessage(__("YOUR FEEDBACK IS SUBMITTED SUCCESSFULLY."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong! Your feedback has not submitted. Please try again.'));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

   

}