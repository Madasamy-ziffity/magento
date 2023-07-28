<?php

namespace Learning\Feedback\Ui\Component;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class AcceptButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];

        if (!$this->getStatus())
            $data = [
                'label' => __('Accept'),
                'class' => 'primary',
                'id' => 'feedback-accept-button',
                'data_attribute' => [
                    'url' => $this->getAcceptUrl()
                ],
                'on_click' => sprintf("location.href = '%s';", $this->getAcceptUrl()),
                'sort_order' => 20,
            ];

        return $data;
    }

    /**
     * @return string
     */
    public function getAcceptUrl()
    {
        return $this->getUrl('*/*/accept', ['id' => $this->getId()]);
    }

}