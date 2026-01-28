<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * @category   Mavenbird
 * @package    Mavenbird_RefundRequest
 */

namespace Mavenbird\RefundRequest\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Mavenbird\RefundRequest\Helper\Data;
use Mavenbird\RefundRequest\Model\ResourceModel\Label\CollectionFactory;

class MassDisable extends Action
{
    /**
     * ACL resource
     */
    const ADMIN_RESOURCE = 'Magento_Sales::sales_mavenbird_refund_request_label';

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    public function __construct(
        Action\Context $context,
        Data $helper,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->helper = $helper;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT);

        // if (!$this->helper->isModuleEnabledForAdmin()) {
        //     $this->messageManager->addWarningMessage(__('Module is disabled.'));
        //     return $resultRedirect->setPath('*/*/');
        // }

        $collection = $this->filter
            ->getCollection($this->collectionFactory->create());

        $count = 0;

        foreach ($collection as $item) {
            $item->setData('status', 1);
            $item->save();
            $count++;
        }

        if ($count) {
            $this->messageManager->addSuccessMessage(
                __('%1 option(s) have been disabled.', $count)
            );
        }

        return $resultRedirect->setPath('*/*/');
    }
}
