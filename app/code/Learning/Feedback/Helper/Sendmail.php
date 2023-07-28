<?php

namespace Learning\Feedback\Helper;

use Exception;
use Magento\Framework\DataObject;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;

/** Description of Mail. */
class Sendmail extends AbstractHelper
{

    /** @var ManagerInterface */
    protected $messageManager;

    /** @var StateInterface */
    private $_inlineTranslation;

    /** @var TransportBuilder */
    private $_transportBuilder;

    /** @var ScopeConfigInterface */
    private $_scopeConfig;

    /** @var string custom email template */
    private $_emailTemplate;

    /** @var array custom email template variables */
    private $_emailTemplateVar;

    /** @var array */
    private $_recipient;

    /**
     * @param Context $context
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager
    )
    {
        $this->messageManager = $messageManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        parent::__construct($context);
    }

    /**
     * @param string $template
     * @param array  $var
     */
    public function setTemplate($template, $var = [])
    {
        $this->_emailTemplate = $template;
        $this->_emailTemplateVar = $var;
    }

    /** @param array $recipient */
    public function setRecipient($recipient)
    {
        $this->_recipient = $recipient;
    }

    /** @return bool send status */
    public function send()
    {
        $this->_inlineTranslation->suspend();
        try {
            $storeAdmin = $this->_scopeConfig->getValue('trans_email/ident_general/email', ScopeInterface::SCOPE_STORE);

            $sender = [
                'name' => 'Customer Relationship Manager',
                'email' => $storeAdmin,
            ];

            $postObject = new DataObject();
            $postObject->setData($this->_emailTemplateVar);

            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->_emailTemplate) // this code we have mentioned in the email_templates.xml
                ->setTemplateOptions([
                    'area' => Area::AREA_FRONTEND, // this is using frontend area to get the template file
                    'store' => Store::DEFAULT_STORE_ID,
                ])
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($sender)
                ->addTo($this->_recipient['email'], $this->_recipient['firstname'])
                ->addBcc($storeAdmin)
                ->getTransport();

            $transport->sendMessage();

            $this->_inlineTranslation->resume();

            return true;
        } catch (Exception $e) {
            //$this->messageManager->addErrorMessage(__('Error').$e->getMessage());
            $this->_inlineTranslation->resume();
        }

        return false;
    }

    /**
     * @param array $data
     * @param string $template
     * @return bool Status of the email
     */
    public function sendMail($template , $data)
    {
        $data['name'] = $data['firstname'] ." ". $data['lastname'];
        $this->setRecipient($data);
        $this->setTemplate($template, $data);

        return $this->send();
    }
}