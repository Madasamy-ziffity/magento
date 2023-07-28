<?php

namespace Learning\Feedback\Model\ResourceModel;


class Feedback extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    /**
     * Resource initialisation
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('customer_feedback', 'id');
    }
}