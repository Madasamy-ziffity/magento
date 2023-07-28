<?php

namespace Learning\Feedback\Controller\Adminhtml\View;

use Magento\Backend\App\Action;
use Learning\Feedback\Helper\Sendmail;
use Learning\Feedback\Model\FeedbackFactory;

class Accept extends Action
{

    /** @var FeedbackFactory */
    protected $feedbackFactory;

    /** @var Sendmail */
    protected $mailer;

    /**
     * @param Action\Context  $context
     * @param FeedbackFactory $feedbackFactory
     * @param Sendmail        $mailer
     */
    public function __construct(Action\Context $context, FeedbackFactory $feedbackFactory, Sendmail $mailer)
    {
        $this->feedbackFactory = $feedbackFactory;
        $this->mailer = $mailer;
        parent::__construct($context);
    }

    /** @return boolean */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Learning_Feedback::feedback');
    }

    /**
     * Execute action based on request and return result.
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface
     *
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if (isset($id)) {
            $feedback = $this->feedbackFactory->create();

            $item = $feedback->load($id);

            $item->setData('status', 1)
                    ->save();

            $mailStatus = $this->mailer->sendMail("feedback_accept_template" , (array)$item->getData());

            if ($mailStatus) {
                $this->messageManager->addSuccess(__('Feedback approval status has sent to customer by email.'));
            } else {
                $this->messageManager->addSuccess(__('Feedback approval status has sent to customer by email..'));
            }

            $result = $this->resultRedirectFactory->create();
            $result->setPath('*/*');

            return $result;
        }
    }

}