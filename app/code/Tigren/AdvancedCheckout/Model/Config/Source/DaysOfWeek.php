<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class DaysOfWeek
 * @package Tigren\AdvancedCheckout\Model\Config\Source
 * Tigren Solutions <info@tigren.com>
 */
class DaysOfWeek implements ArrayInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 'monday',
                'label' => __('Monday')
            ],
            [
                'value' => 'tuesday',
                'label' => __('Tuesday')
            ],
            [
                'value' => 'wednesday',
                'label' => __('Wednesday')
            ],
            [
                'value' => 'thursday',
                'label' => __('Thursday')
            ],
            [
                'value' => 'friday',
                'label' => __('Friday')
            ],
            [
                'value' => 'saturday',
                'label' => __('Saturday')
            ],
            [
                'value' => 'sunday',
                'label' => __('Sunday')
            ]
        ];
    }
}
