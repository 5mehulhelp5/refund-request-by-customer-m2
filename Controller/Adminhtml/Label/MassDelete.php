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
use Mavenbird\RefundRequest\Model\ResourceModel\Label\CollectionFactory;

class MassDelete extends Action
{
    /**
     * ACL resource
     */
    const ADMIN_RESOURCE = 'Magento_Sales::sales_mavenbird_refund_request_label';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * MassDelete constructor.
     */
    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute mass delete
     */
    public function execute()
    {
        $collection = $this->filter
            ->getCollection($this->collectionFactory->create());

        $deleted = 0;

        foreach ($collection as $item) {
            try {
                $item->delete();
                $deleted++;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while deleting item.')
                );
            }
        }

        if ($deleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $deleted)
            );
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('*/*/');
    }
}
