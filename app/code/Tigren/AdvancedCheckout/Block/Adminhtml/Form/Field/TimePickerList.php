<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Block\Adminhtml\Form\Field;


use Exception;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\DataObject;

/**
 * Class TimePickerList
 * @package Tigren\AdvancedCheckout\Block\Adminhtml\Form\Field
 * Tigren Solutions <info@tigren.com>
 */
class TimePickerList extends AbstractFieldArray
{
    /**
     * Initialise form fields
     *
     * @return void
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('start_time', ['label' => __('From'), 'class' => 'timepicker']);
        $this->addColumn('end_time', ['label' => __('To'), 'class' => 'timepicker2']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Time');

        parent::_prepareToRender();
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $key_start_time = 'start_time';
        $key_end_time = 'end_time';
        if (!isset($row[$key_start_time]) && !isset($row[$key_end_time])) {
            return;
        }
        $rowId = $row['_id'];
        try {
            $sourceStartTime = $row[$key_start_time];
            $sourceEndTime = $row[$key_end_time];

            $renderedStartTime = $sourceStartTime;
            $renderedEndTime = $sourceEndTime;

            $row[$key_start_time] = $renderedStartTime;
            $row[$key_end_time] = $renderedEndTime;

            $columnValuesStartTime = $row['column_values_start_time'];
            $columnValuesEndTime = $row['column_values_end_time'];
            $columnValuesStartTime[$this->_getCellInputElementId($rowId, $key_start_time)] = $renderedStartTime;
            $columnValuesEndTime[$this->_getCellInputElementId($rowId, $key_end_time)] = $renderedEndTime;
            $row['column_values_start_time'] = $columnValuesStartTime;
            $row['column_values_end_time'] = $columnValuesEndTime;
        } catch (Exception $e) {
        }
    }

    /**
     * Get the grid and scripts contents
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $html = parent::_getElementHtml($element);
        $script = <<<JS
            <script type="text/javascript">
                require(["jquery", "jquery/ui","jquery-timepicker"], function ($) {
                $(function(){
                    function bindTimePicker() {
                        setTimeout(function() {
                            $('.timepicker').timepicker({
                                timeFormat: 'HH:mm ',
                                interval: 60,
                                minTime: '00',
                                maxTime: '23',
                                startTime: '05:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
                            $('.timepicker2').timepicker({
                                timeFormat: 'HH:mm ',
                                interval: 60,
                                minTime: '00',
                                maxTime: '23',
                                startTime: '05:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
                                    }, 50);

                    }

                    bindTimePicker();
                    $('button.action-add').on('click', function(e) {
                        bindTimePicker();
                    });
                })
            });
            </script>;
JS;
        $html .= $script;
        return $html;
    }

}
