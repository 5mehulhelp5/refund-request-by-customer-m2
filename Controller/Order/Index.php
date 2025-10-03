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
namespace Mavenbird\RefundRequest\Controller\Order;

use Mavenbird\RefundRequest\Helper\Data;
use Mavenbird\RefundRequest\Helper\Email;
use Mavenbird\RefundRequest\Model\RequestFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\Data\Form\FormKey\Validator;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Email
     */
    protected $emailSender;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var OrderInterface
     */
    protected $orderInterface;

    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * @var
     */
    protected $resultFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * Index constructor.
     * @param Email $emailSender
     * @param Data $helper
     * @param OrderInterface $orderInterface
     * @param RequestFactory $requestFactory
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Validator $formKeyValidator
     */
    public function __construct(
        Email $emailSender,
        Data $helper,
        OrderInterface $orderInterface,
        RequestFactory $requestFactory,
        Context $context,
        PageFactory $resultPageFactory,
        Validator $formKeyValidator
    ) {
        $this->emailSender        = $emailSender;
        $this->helper             = $helper;
        $this->orderInterface     = $orderInterface;
        $this->requestFactory    = $requestFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->formKeyValidator = $formKeyValidator;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage("Invalid request!");
            return $resultRedirect->setPath('customer/account/');
        }
        $model          = $this->requestFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if ($data) {
            if ($this->helper->getConfigEnableDropdown()) {
                $option = $data['mavenbird-option'];
            } else {
                $option = '';
            }
            if ($this->helper->getConfigEnableOption()) {
                $radio = $data['mavenbird-radio'];
            } else {
                $radio = '';
            }
            $reasonComment = $data['mavenbird-refund-reason'];
            $incrementId   = $data['mavenbird-refund-order-id'];
            $orderData     = $this->orderInterface->loadByIncrementId($incrementId);
            try {
                $model->setOption($option);
                $model->setRadio($radio);
                $model->setOrderId($incrementId);
                $model->setReasonComment($reasonComment);
                $model->setCustomerName($orderData->getCustomerName());
                $model->setCustomerEmail($orderData->getCustomerEmail());
                $model->save();
                try {
                    $this->sendEmail($orderData);
                    $this->messageManager
                        ->addSuccessMessage(__('Your refund request number #' . $incrementId . ' has been submited.'));
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                    return $resultRedirect->setPath('customer/account/');
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('customer/account/');
            }
        }
        return $resultRedirect->setPath('customer/account/');
    }

    /**
     * @param $orderData
     */
    protected function sendEmail($orderData)
    {
        $emailTemplate = $this->helper->getEmailTemplate();
        $adminEmail    = $this->helper->getAdminEmail();
        $adminEmails   = explode(",", $adminEmail);
        $countEmail    = count($adminEmails);
        if ($countEmail > 1) {
            foreach ($adminEmails as $value) {
                $value             = str_replace(' ', '', $value ?? '');
                $emailTemplateData = [
                    'adminEmail'   => $value,
                    'incrementId'  => $orderData->getIncrementId(),
                    'customerName' => $orderData->getCustomerName(),
                    'createdAt'    => $orderData->getCreatedAt(),
                ];
                $this->emailSender->sendEmail($value, $emailTemplate, $emailTemplateData);
            }
        } else {
            $emailTemplateData = [
                'adminEmail'   => $adminEmail,
                'incrementId'  => $orderData->getIncrementId(),
                'customerName' => $orderData->getCustomerName(),
                'createdAt'    => $orderData->getCreatedAt(),
            ];
            $this->emailSender->sendEmail($adminEmail, $emailTemplate, $emailTemplateData);
        }
    }
}
