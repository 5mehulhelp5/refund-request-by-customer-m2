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
namespace Mavenbird\RefundRequest\Model\Attribute\Source;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Mavenbird\RefundRequest\Model\ResourceModel\Status as mavenbirdRefundStatus;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Remind Status values
     */
    const PENDING = 0;
    const ACCEPT = 1;
    const REJECT = 2;
    const NA = null;
    /**
     * To Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::PENDING,  'label' => __('Pending')],
            ['value' => self::ACCEPT,  'label' => __('Accept')],
            ['value' => self::REJECT,  'label' => __('Reject')],
            ['value' => self::NA,  'label' => __('N/A')]
        ];
    }
}
