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

namespace Mavenbird\RefundRequest\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Status for update refund status
 */
class Status extends AbstractDb
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $datetime;

    /**
     * Status constructor.
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $datetime
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime,
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        $this->datetime = $datetime;
        parent::__construct($context);
    }
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mavenbird_refundrequest', 'increment_id');
    }

    /**
     * Update status and time in mavenbird_refundrequest table
     * @param array $incrementIds
     * @param int $refundStatus
     */
    public function updateStatusAndTime($incrementIds, $refundStatus)
    {
        $timeUpdate = $this->datetime->gmtDate('Y-m-d H:i:s');
        $connection = $this->getConnection();
        $where =  ['increment_id IN (?)' => $incrementIds];
        try {
            $connection->beginTransaction();
            $connection->update(
                $this->getMainTable(),
                ['updated_at' => $timeUpdate,'refund_status' => $refundStatus],
                $where
            );
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
        }
    }

    /**
     * Update refund status in sales_order_grid table
     *
     * @param array $incrementIds
     * @param int $status
     */
    public function updateOrderRefundStatus($incrementIds, $status)
    {
        $sales_order_grid = $this->getTable('sales_order_grid');
        $connection = $this->getConnection();
        $where =  ['increment_id IN (?)' => $incrementIds];
        try {
            $connection->beginTransaction();
            $connection->update(
                $sales_order_grid,
                ['refund_status' => $status],
                $where
            );
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
        }
    }
}
