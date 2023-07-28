<?php

namespace Learning\Feedback\Model\ResourceModel\Feedback;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     * @codingStandardsIgnoreStart
     */
    protected $_idFieldName = 'id';
    /** Collection initialisation */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('Learning\Feedback\Model\Feedback', 'Learning\Feedback\Model\ResourceModel\Feedback');
    }
}