<?php

namespace Learning\Feedback\Ui\Component;

use Magento\Backend\Block\Widget\Context;
use Learning\Feedback\Model\FeedbackFactory;

class GenericButton
{

    /**
     * @var \Magento\Backend\Block\Widget\Context
     */
    protected $context;

    /**
     * @var \Learning\Feedback\Model\FeedbackFactory
     */
    protected $feedback;

    /**
     * GenericButton constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Learning\Feedback\Model\FeedbackFactory $feedback
     */
    public function __construct(Context $context, FeedbackFactory $feedback)
    {
        $this->context = $context;
        $this->feedback = $feedback;
    }

    /**
     * @param string $route
     * @param array $param
     * @return string
     */
    public function getUrl($route = '', $param = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $param);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->context->getRequest()->getParam('id');
    }

    /**
     * @return boolean|null current status of the feedback
     */
    public function getStatus()
    {
        $model = $this->feedback->create();
        return $model->load($this->getId())->getStatus();
    }

}