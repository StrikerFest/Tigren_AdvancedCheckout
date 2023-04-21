<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Block;

use Magento\Backend\Block\Template;

/**
 * Class CustomDelivery
 * @package Tigren\AdvancedCheckout\Block
 * Tigren Solutions <info@tigren.com>
 */
class CustomDelivery extends Template
{
    /**
     * @return string
     */
    public function getFormAction(): string
    {
        return $this->getUrl('');
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getFormFieldValue($field)
    {

        return $this->_getRequest()->getParam($field);
    }

    /**
     * @return void
     */
    public function validateForm()
    {

    }

    /**
     * @return void
     */
    public function processForm()
    {

    }

    /**
     * @return CustomDelivery|$this
     */
    protected function _prepareLayout(): CustomDelivery|static
    {
        parent::_prepareLayout();
        return $this;
    }
}
