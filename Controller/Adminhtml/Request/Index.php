<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * @category   Mavenbird
 * @package    Mavenbird_RefundRequest
 */

namespace Mavenbird\RefundRequest\Controller\Adminhtml\Request;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * ACL resource
     */
    const ADMIN_RESOURCE = 'Magento_Sales::sales_mavenbird_refund_request';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute action
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mavenbird_RefundRequest::request');
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Refund Request by Customer'));

        return $resultPage;
    }
}
