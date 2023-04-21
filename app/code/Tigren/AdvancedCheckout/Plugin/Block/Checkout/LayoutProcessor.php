<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Plugin\Block\Checkout;

use Exception;
use Magento\Store\Model\ScopeInterface;
use Tigren\AdvancedCheckout\Model\Config\Source\DaysOfWeek;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class LayoutProcessor
 * @package Tigren\AdvancedCheckout\Plugin\Block\Checkout
 * Tigren Solutions <info@tigren.com>
 */
class LayoutProcessor
{
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
    ) {
        $this->scopeConfig = $scopeConfig;

    }

    /**
     * Process js Layout of block
     *
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     * @throws Exception
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, array $jsLayout): array
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['delivery_date'] = $this->processDeliveryDateAddress('shippingAddress');
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['delivery_time'] = $this->processDeliveryTimeAddress('shippingAddress');
        return $jsLayout;
    }

    /**
     * Process provided address.
     *
     * @param string $dataScopePrefix
     * @return array
     */
    private function processDeliveryDateAddress(string $dataScopePrefix): array
    {
        return [
            'component' => 'Tigren_AdvancedCheckout/js/custom-date',
            'config' => [
                'customScope' => $dataScopePrefix . '.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/date',
                'id' => 'delivery_date',
                'options' => [
                    'dateFormat' => 'y-MM-dd',
                    'minDate' => 'new Date()', // Disable days before today

                ]
            ],
            'dataScope' => $dataScopePrefix . '.custom_attributes.delivery_date',
            'label' => __('Delivery Date'),
            'provider' => 'checkoutProvider',
            'validation' => [
                'required-entry' => true
            ],
            'sortOrder' => 201,
            'visible' => true,
            'imports' => [
                'initialOptions' => 'index = checkoutProvider:dictionaries.delivery_date',
                'setOptions' => 'index = checkoutProvider:dictionaries.delivery_date'
            ]
        ];
    }

    /**
     * @throws Exception
     */
    private function processDeliveryTimeAddress(string $dataScopePrefix): array
    {
        $jsonData = $this->scopeConfig->getValue('delivery_configuration/general/delivery_time_frame',
            ScopeInterface::SCOPE_STORE);

        $data = json_decode($jsonData, true);

        $combinedData = array();

        if ($data) {
            foreach ($data as $key => $value) {
                $startTime = trim($value['start_time']);
                $endTime = trim($value['end_time']);
                $combinedTime = $startTime . ' - ' . $endTime;
                $combinedData[] = [
                    'value' => $combinedTime,
                    'label' => __($combinedTime)
                ];
            }
        } else {
            throw new Exception('Invalid or empty JSON data.');
        }
        return [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => $dataScopePrefix . '.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'options' => $combinedData,
                'id' => 'delivery_time',
            ],
            'dataScope' => $dataScopePrefix . '.custom_attributes.delivery_time',
            'label' => __('Delivery Time'),
            'provider' => 'checkoutProvider',
            'validation' => [
                'required-entry' => true
            ],
            'sortOrder' => 201,
            'visible' => true,
            'imports' => [
                'initialOptions' => 'index = checkoutProvider:dictionaries.delivery_time',
                'setOptions' => 'index = checkoutProvider:dictionaries.delivery_time'
            ]
        ];
    }

}
