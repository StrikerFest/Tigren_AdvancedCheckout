<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Helper;


use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{

    /**
     * Admin configuration paths
     *
     */

    const XML_PATH_EXCLUDE_DATES = 'order_section/order_settings/excludedates';

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $_serializer;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Serialize\Serializer\Json $serializer
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Serialize\Serializer\Json $serializer
    ) {
        $this->_serializer = $serializer;
        parent::__construct($context);
    }

    /**
     * Returns excluded dates (dates which will be disabled on the date grid on checkout)
     * Returns raw value as string (serialized array)
     *
     * @return string
     */
    private function getRawExcludeDates($storeId = null)
    {
        $excludeDates = $this->scopeConfig->getValue(
            self::XML_PATH_EXCLUDE_DATES,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return $excludeDates;
    }

    /**
     * Returns excluded dates
     * @return array
     */
    public function getExcludeDates()
    {
        $raw = $this->getRawExcludeDates();
        if (empty($raw)) {
            return [];
        }
        if (!$values = $this->_serializer->unserialize($raw)) {
            return [];
        }
        $dates = array();
        foreach ($values as $value) {
            if (!isset($value['date'])) {
                continue;
            }
            array_push($dates, $value['date']);
        }
        return $dates;
    }
}
