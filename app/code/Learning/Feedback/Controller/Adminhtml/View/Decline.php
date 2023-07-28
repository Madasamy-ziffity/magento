<?php

namespace Learning\Feedback\Controller\Adminhtml\View;

use Magento\Backend\App\Action;
use Learning\Feedback\Helper\Sendmail;
use Learning\Feedback\Model\FeedbackFactory;

class Decline extends Action
{
    /**
     * Model instance of Feedback.
     *
     * @var FeedbackFactory
     */
    protected $feedbackFactory;

    /**
     *
     * @var Sendmail
     */
    protected $mailer;

    /**
     * Class initializer.
     *
     * @param Action\Context   $context
     * @param FeedbackFactory  $feedbackFactory
     * @param Sendmail         $mailer
     */
    public function __construct(Action\Context $context, FeedbackFactory $feedbackFactory, Sendmail $mailer)
    {
        $this->feedbackFactory = $feedbackFactory;
        $this->mailer = $mailer;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Learning_Feedback::feedback');
    }

    /**
     * Execute action based on request and return result.
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     *
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if (isset($id)) {
            $feedback = $this->feedbackFactory->create();

            $item = $feedback->load($id);

            $item->setData('status', 0)
                    ->save();

            $mailStatus = $this->mailer->sendMail("feedback_decline_template" , (array)$item->getData());

            if ($mailStatus) {
                $this->messageManager->addSuccess(__('Feedback approval status has sent to customer by email.'));
            } else {
                $this->messageManager->addError(__('Feedback approval status has sent to customer by email has declined.'));
            }

            $result = $this->resultRedirectFactory->create();
            $result->setPath('*/*');

            return $result;
        }
    }

}