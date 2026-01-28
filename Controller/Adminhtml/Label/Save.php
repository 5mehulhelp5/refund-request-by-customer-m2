<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * @category   Mavenbird
 * @package    Mavenbird_RefundRequest
 */

namespace Mavenbird\RefundRequest\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\Controller\ResultFactory;
use Mavenbird\RefundRequest\Model\LabelFactory;

class Save extends Action
{
    /**
     * ACL resource
     */
    const ADMIN_RESOURCE = 'Magento_Sales::sales_mavenbird_refund_request_label';

    /**
     * @var Session
     */
    protected $backendSession;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var LabelFactory
     */
    protected $labelFactory;

    /**
     * Save constructor.
     */
    public function __construct(
        Action\Context $context,
        Session $backendSession,
        Registry $coreRegistry,
        LabelFactory $labelFactory
    ) {
        parent::__construct($context);
        $this->backendSession = $backendSession;
        $this->coreRegistry  = $coreRegistry;
        $this->labelFactory  = $labelFactory;
    }

    /**
     * Save action
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT);

        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $model = $this->labelFactory->create();
            $model->setData($data);
            $model->save();

            $this->messageManager->addSuccessMessage(
                __('The option has been saved.')
            );

            return $resultRedirect->setPath('*/*/');

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Something went wrong while saving the option.')
            );

            return $resultRedirect->setPath('*/*/');
        }
    }
}
