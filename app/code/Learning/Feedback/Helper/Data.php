<?php

namespace Learning\Feedback\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{

    const MODULE_ENABLE = "learning_feedback/customer/feedback";

    public function getDefaultConfig($path, $storeCode = null)
    {
        return $this->scopeConfig->getValue($path, ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $storeCode);
    }

    public function getCustomerFeedback($pathId, $storeCode = null)
    {
        return $this->getDefaultConfig(self::MODULE_ENABLE.'feedback/'.$pathId, $storeCode );
    }
}