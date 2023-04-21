<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Model\Config\Backend;


use DateTime;
use Exception;
use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;

/**
 * Class DatePickerList
 * @package Tigren\AdvancedCheckout\Model\Config\Backend
 * Tigren Solutions <info@tigren.com>
 */
class DatePickerList extends ArraySerialized
{
    /**
     * On save convert front value format like "20/04/2023" to backend format "2023-04-20"
     *
     * @return $this
     */
    public function beforeSave(): static
    {
        $value = [];
        $values = $this->getValue();
        foreach ((array)$values as $key => $data) {
            if ($key == '__empty') {
                continue;
            }
            if (!isset($data['date'])) {
                continue;
            }
            try {
                $value[$key] = [
                    'date' => $data['date'],
                ];
            } catch (Exception $e) {
            }
        }
        $this->setValue($value);
        return parent::beforeSave();
    }
}
