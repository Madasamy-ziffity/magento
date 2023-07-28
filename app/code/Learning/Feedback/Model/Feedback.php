<?php

namespace Learning\Feedback\Model;

use Magento\Framework\Model\AbstractModel;
class Feedback extends AbstractModel 
{
    /** Cache tag */
    const CACHE_TAG = 'customer_feedback';

    /**
     * Initialise resource model
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('Learning\Feedback\Model\ResourceModel\Feedback');
    }

    public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}

    }