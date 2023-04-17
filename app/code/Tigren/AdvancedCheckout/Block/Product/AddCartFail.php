<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Block\Product;

use Magento\Checkout\Model\Cart;
use Magento\Framework\View\Element\Template\Context;


/**
 * Class AddCartFail
 * @package Tigren\AdvancedCheckout\Block\Product
 * Tigren Solutions <info@tigren.com>
 */
class AddCartFail extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Cart
     */
    protected Cart $_cart;

    /**
     * @param Context $context
     * @param Cart $cart
     */
    public function __construct(
        Context $context,
        Cart $cart,
    )
    {
        parent::__construct($context);
        $this->_cart = $cart;
    }
}
