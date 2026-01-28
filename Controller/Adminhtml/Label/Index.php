<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * @category   Mavenbird
 * @package    Mavenbird_RefundRequest
 */

namespace Mavenbird\RefundRequest\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * ACL resource
     */
    const ADMIN_RESOURCE = 'Magento_Sales::sales_mavenbird_refund_request_label';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
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
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mavenbird_RefundRequest::label');
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Refund Request Dropdown Options'));

        return $resultPage;
    }
}
