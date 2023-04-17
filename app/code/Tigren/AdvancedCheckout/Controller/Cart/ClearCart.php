<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\Cart;


use Magento\Backend\App\Action\Context;
use Magento\Checkout\Model\Cart;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class ClearCart
 * @package Tigren\AdvancedCheckout\Controller\Cart
 * Tigren Solutions <info@tigren.com>
 */
class ClearCart extends \Magento\Framework\App\Action\Action
{
    /**
     * @var bool|PageFactory
     */
    protected bool|PageFactory $resultPageFactory = false;
    /**
     * @var Cart
     */
    protected Cart $_cart;

    /**
     * @param PageFactory $resultPageFactory
     * @param Cart $cart
     * @param Context $context
     */
    public function __construct(
        PageFactory $resultPageFactory,
        Cart $cart,
        Context $context,
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_cart = $cart;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('View clear'));

        $this->_cart->truncate()->save();
    }
}
