<?php
namespace Mavenbird\RefundRequest\Controller\Adminhtml\Request;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Mavenbird\RefundRequest\Model\ResourceModel\Request\CollectionFactory;

class MassDelete extends Action
{
    const ADMIN_RESOURCE = 'Magento_Sales::sales_mavenbird_refund_request';

    protected $filter;
    protected $collectionFactory;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $collection = $this->filter->getCollection(
            $this->collectionFactory->create()
        );

        $count = 0;
        foreach ($collection as $item) {
            $item->delete();
            $count++;
        }

        $this->messageManager->addSuccessMessage(
            __('%1 request(s) have been deleted.', $count)
        );

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('*/*/');
    }
}
