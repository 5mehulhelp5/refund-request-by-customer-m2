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

use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory;
use Mavenbird\RefundRequest\Model\ResourceModel\Status;

class RefundOrder implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $orderStatusCollection;

    /**
     * @var Status
     */
    protected $mavenbirdRefundStatus;

    /**
     * RefundOrder constructor.
     * @param CollectionFactory $orderStatusCollection
     * @param Status $mavenbirdRefundStatus
     */
    public function __construct(
        CollectionFactory $orderStatusCollection,
        Status $mavenbirdRefundStatus
    ) {
        $this->orderStatusCollection = $orderStatusCollection;
        $this->mavenbirdRefundStatus = $mavenbirdRefundStatus;
    }

    /**
     * @return \Magento\Sales\Model\ResourceModel\Order\Status\Collection
     */
    public function getStatus()
    {
        return $this->orderStatusCollection->create();
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $array = [];
        foreach ($this->getStatus() as $value) {
            $array[] = ['value' => $value->getStatus(), 'label' => $value->getLabel()];
        }
        return $array;
    }
}
