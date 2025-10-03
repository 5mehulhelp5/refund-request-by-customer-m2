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
namespace Mavenbird\RefundRequest\Model;

use Magento\Framework\Model\AbstractModel;

class Request extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\Mavenbird\RefundRequest\Model\ResourceModel\Request::class);
    }

    /**
     * @param $oderId
     */
    public function setOrderId($oderId)
    {
        $this->setData("increment_id", $oderId);
    }

    /**
     * @param $reasonComment
     */
    public function setReasonComment($reasonComment)
    {
        $this->setData("reason_comment", $reasonComment);
    }

    /**
     * @param $time
     */
    public function setTime($time)
    {
        $this->setData("create_at", $time);
    }

    /**
     * @param $option
     */
    public function setOption($option)
    {
        $this->setData("reason_option", $option);
    }

    /**
     * @param $radio
     */
    public function setRadio($radio)
    {
        $this->setData("radio_option", $radio);
    }

    /**
     * @param $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->setData("customer_name", $customerName);
    }

    /**
     * @param $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->setData("customer_email", $customerEmail);
    }
}
