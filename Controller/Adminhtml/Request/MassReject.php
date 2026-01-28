<?php
namespace Mavenbird\RefundRequest\Controller\Adminhtml\Request;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Mavenbird\RefundRequest\Helper\Data;
use Mavenbird\RefundRequest\Helper\Email;
use Mavenbird\RefundRequest\Model\ResourceModel\Request\CollectionFactory;
use Mavenbird\RefundRequest\Model\ResourceModel\Status;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Locale\ListsInterface;

class MassReject extends Action
{
    const ADMIN_RESOURCE = 'Magento_Sales::sales_mavenbird_refund_request';

    // ⚠️ VERIFY THIS VALUE WITH DB
    const STATUS_REJECT = 2;

    protected $helper;
    protected $emailSender;
    protected $filter;
    protected $collectionFactory;
    protected $scopeConfig;
    protected $timezone;
    protected $localeLists;
    protected $statusResourceModel;

    public function __construct(
        Action\Context $context,
        Email $emailSender,
        Data $helper,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ScopeConfigInterface $scopeConfig,
        TimezoneInterface $timezone,
        ListsInterface $localeLists,
        Status $statusResourceModel
    ) {
        parent::__construct($context);
        $this->emailSender = $emailSender;
        $this->helper = $helper;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->timezone = $timezone;
        $this->localeLists = $localeLists;
        $this->statusResourceModel = $statusResourceModel;
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT);

        // ✅ Module enable check
        // if (!$this->helper->isModuleEnabledForAdmin()) {
        //     $this->messageManager->addWarningMessage(__('Module is disabled.'));
        //     return $resultRedirect->setPath('*/*/');
        // }

        $collection = $this->filter
            ->getCollection($this->collectionFactory->create());

        if (!$collection->getSize()) {
            $this->messageManager->addWarningMessage(__('No records selected.'));
            return $resultRedirect->setPath('*/*/');
        }

        $incrementIds = [];
        $count = 0;

        foreach ($collection as $item) {
            if ((int)$item->getRefundStatus() !== self::STATUS_REJECT) {
                $incrementIds[] = $item->getIncrementId();
                $this->sendEmail($item);
                $count++;
            }
        }

        // ✅ CRITICAL SAFETY CHECK
        if (empty($incrementIds)) {
            $this->messageManager->addNoticeMessage(__('No records were updated.'));
            return $resultRedirect->setPath('*/*/');
        }

        // ✅ DB UPDATE (THIS IS THE MAIN PART)
        $this->statusResourceModel->updateOrderRefundStatus(
            $incrementIds,
            self::STATUS_REJECT
        );

        $this->statusResourceModel->updateStatusAndTime(
            $incrementIds,
            self::STATUS_REJECT
        );

        $this->messageManager->addSuccessMessage(
            __('%1 request(s) have been rejected.', $count)
        );

        return $resultRedirect->setPath('*/*/');
    }

    protected function sendEmail($item)
    {
        $timezoneValue = $this->scopeConfig->getValue(
            'general/locale/timezone',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $date = $this->timezone->date();
        $timezoneLabel = $this->getTimezoneLabelByValue($timezoneValue);

        $emailTemplateData = [
            'incrementId'  => $item->getIncrementId(),
            'id'           => $item->getId(),
            'timeApproved' => $date->format('Y-m-d h:i:s A') . ' ' . $timezoneLabel,
            'customerName'=> $item->getCustomerName()
        ];

        $this->emailSender->sendEmail(
            $item->getCustomerEmail(),
            $this->helper->getRejectEmailTemplate(),
            $emailTemplateData
        );
    }

    protected function getTimezoneLabelByValue($timezoneValue)
    {
        foreach ($this->localeLists->getOptionTimezones() as $zone) {
            if ($zone['value'] === $timezoneValue) {
                return $zone['label'];
            }
        }
        return '';
    }
}
