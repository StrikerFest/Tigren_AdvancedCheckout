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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

/**
 * Class TimePickerList
 * @package Tigren\AdvancedCheckout\Model\Config\Backend
 * Tigren Solutions <info@tigren.com>
 */
class TimePickerList extends ArraySerialized
{

    /**
     *
     * @return $this|null
     */
    public function beforeSave(): ?static
    {
        $value = [];
        $values = $this->getValue();
        foreach ((array)$values as $key => $data) {
            if ($key == '__empty') {
                continue;
            }
            if (!isset($data['start_time']) && !isset($data['end_time'])) {
                continue;
            }
            try {
                $start_time = $data['start_time'];
                $end_time = $data['end_time'];
                if ($start_time >= $end_time) {
                    throw new LocalizedException(__('Start time cannot be greater than or equal to end time.'));
                }
                $value[$key] = [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                ];
            } catch (LocalizedException $e) {
            }
        }
        $this->setValue($value);
        return parent::beforeSave();
    }
}
