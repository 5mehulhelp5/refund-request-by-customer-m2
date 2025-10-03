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
namespace Mavenbird\RefundRequest\Helper;

class RecentOder
{

    /**
     * @var Data
     */
    protected $helperConfigAdmin;

    /**
     * RecentOder constructor.
     * @param Data $helperConfigAdmin
     */
    public function __construct(
        Data $helperConfigAdmin
    ) {
        $this->helperConfigAdmin = $helperConfigAdmin;
    }

    //General config admin
    /**
     * @return string
     */
    public function getTemplate()
    {
        if ($this->helperConfigAdmin->getConfigEnableModule()) {
            $template =  'Mavenbird_RefundRequest::order/recent.phtml';
        } else {
            $template = 'Magento_Sales::order/recent.phtml';
        }

        return $template;
    }

    /**
     * @return string
     */
    public function getTemplateMyOder()
    {
        if ($this->helperConfigAdmin->getConfigEnableModule()) {
            $template =  'Mavenbird_RefundRequest::order/history.phtml';
        } else {
            $template = 'Magento_Sales::order/history.phtml';
        }
        return $template;
    }
}
