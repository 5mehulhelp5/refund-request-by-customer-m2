<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_RefundRequest
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */
namespace Mavenbird\RefundRequest\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Config for enable module
     * MAVENBIRD_CONFIG_ENABLE_MODULE
     */
    const MAVENBIRD_CONFIG_ENABLE_MODULE = 'mavenbird_refundrequest/mavenbird_refundrequest_general/enable';

    /**
     * Config for order refund
     * MAVENBIRD_CONFIG_ORDER_REFUND
     */
    const MAVENBIRD_CONFIG_ORDER_REFUND = 'mavenbird_refundrequest/mavenbird_refundrequest_general/canrefund';

    /**
     * Config for title popup
     * MAVENBIRD_CONFIG_TITLE_POPUP
     */
    const MAVENBIRD_CONFIG_POPUP_TITLE = 'mavenbird_refundrequest/mavenbird_refundrequest_config/popup_title';

    /**
     * Config for enable dropdown
     * MAVENBIRD_CONFIG_ENABLE_DROPDOWN
     */
    const MAVENBIRD_CONFIG_ENABLE_DROPDOWN = 'mavenbird_refundrequest/mavenbird_refundrequest_config/enable_dropdown';

    /**
     * Config for dropdown title
     * MAVENBIRD_CONFIG_DROPDOWN_TITLE
     */
    const MAVENBIRD_CONFIG_DROPDOWN_TITLE = 'mavenbird_refundrequest/mavenbird_refundrequest_config/dropdown_title';

    /**
     * Config for enable option
     * MAVENBIRD_CONFIG_ENABLE_OPTION
     */
    const MAVENBIRD_CONFIG_ENABLE_OPTION = 'mavenbird_refundrequest/mavenbird_refundrequest_config/enable_option';

    /**
     * Config for option title
     * MAVENBIRD_CONFIG_OPTION_TITLE
     */
    const MAVENBIRD_CONFIG_OPTION_TITLE = 'mavenbird_refundrequest/mavenbird_refundrequest_config/option_title';

    /**
     * Config for detail title
     * MAVENBIRD_CONFIG_DETAIL_TITLE
     */
    const MAVENBIRD_CONFIG_DETAIL_TITLE = 'mavenbird_refundrequest/mavenbird_refundrequest_config/detail_title';

    /**
     * Config for config title
     * MAVENBIRD_CONFIG_TITLE
     */
    const MAVENBIRD_CONFIG_POPUP_DESCRIPTION = 'mavenbird_refundrequest/mavenbird_refundrequest_config/popup_description';

    /**
     * Config for admin email
     * MAVENBIRD_CONFIG_ADMIN_EMAIL
     */
    const MAVENBIRD_CONFIG_ADMIN_EMAIL = 'mavenbird_refundrequest/mavenbird_refundrequest_email_config/admin_email';

    /**
     * Config for email template
     * MAVENBIRD_CONFIG_EMAIL_TEMPLATE
     */
    const MAVENBIRD_CONFIG_EMAIL_TEMPLATE = 'mavenbird_refundrequest/mavenbird_refundrequest_email_config/email_template';

    /**
     * Config for email sender
     * MAVENBIRD_CONFIG_EMAIL_SENDER
     */
    const MAVENBIRD_CONFIG_EMAIL_SENDER = 'mavenbird_refundrequest/mavenbird_refundrequest_email_config/email_sender';

    /**
     * Config for accept email
     * MAVENBIRD_CONFIG_ACCEPT_EMAIL
     */
    const MAVENBIRD_CONFIG_ACCEPT_EMAIL = 'mavenbird_refundrequest/mavenbird_refundrequest_email_config/accept_email';

    /**
     * Config for reject email
     * MAVENBIRD_CONFIG_REJECT_EMAIL
     */
    const MAVENBIRD_CONFIG_REJECT_EMAIL = 'mavenbird_refundrequest/mavenbird_refundrequest_email_config/reject_email';

    /**
     * ScopeConfigInterface
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
    }

    //General config admin

    /**
     * Get Config Enable Module
     *
     * @return string
     */
    public function getConfigEnableModule()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_ENABLE_MODULE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getOrderRefund()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_ORDER_REFUND,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Title Module
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_POPUP_DESCRIPTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Title Module
     *
     * @return string
     */
    public function getPopupModuleTitle()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_POPUP_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Enable Dropdown In Modal Popup
     *
     * @return string
     */
    public function getConfigEnableDropdown()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_ENABLE_DROPDOWN,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Title Dropdown Modal Popup
     *
     * @return string
     */
    public function getDropdownTitle()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_DROPDOWN_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Enable Yes/No Option
     *
     * @return string
     */
    public function getConfigEnableOption()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_ENABLE_OPTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Title Yes/No Option
     *
     * @return string
     */
    public function getOptionTitle()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_OPTION_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config
     *
     * @return string
     */
    public function getDetailTitle()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_DETAIL_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getAdminEmail()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_ADMIN_EMAIL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_EMAIL_TEMPLATE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function configSenderEmail()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_EMAIL_SENDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getRejectEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_REJECT_EMAIL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getAcceptEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::MAVENBIRD_CONFIG_ACCEPT_EMAIL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

}
