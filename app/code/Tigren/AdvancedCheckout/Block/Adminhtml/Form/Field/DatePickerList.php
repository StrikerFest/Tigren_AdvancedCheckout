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

class DatePickerList extends AbstractFieldArray
{
    /**
     * Initialise form fields
     *
     * @return void
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('date', ['label' => __('Date'), 'class' => 'js-date-excluded-datepicker']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Date');

        parent::_prepareToRender();
    }

    /**
     * Prepare existing row data object
     * Convert backend date format "2023-04-20" to front format "20/04/2023"
     *
     * @param DataObject $row
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $key = 'date';
        if (!isset($row[$key])) {
            return;
        }
        $rowId = $row['_id'];
        try {
            $sourceDate = $row[$key];
            $renderedDate = $sourceDate;
            $row[$key] = $renderedDate;
            $columnValues = $row['column_values'];
            $columnValues[$this->_getCellInputElementId($rowId, $key)] = $renderedDate;
            $row['column_values'] = $columnValues;
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
                require(["jquery", "jquery/ui"], function ($) {
                $(function(){
                    function bindDatePicker() {
                        setTimeout(function() {
                            $('.js-date-excluded-datepicker').datepicker( { dateFormat: 'dd-mm-yy' } );
                                    }, 50);
                    }

                    bindDatePicker();
                    $('button.action-add').on('click', function(e) {
                        bindDatePicker();
                    });
                })
            });
            </script>
JS;
        $html .= $script;
        return $html;
    }

}
