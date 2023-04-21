<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class CheckoutSubmitAllAfterObserver
 * @package Tigren\AdvancedCheckout\Observer
 * Tigren Solutions <info@tigren.com>
 */
class CheckoutSubmitAllAfterObserver implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer): static
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        if (empty($order) || empty($quote)) {
            return $this;
        }

        $shippingAddress = $quote->getShippingAddress();
        if ($shippingAddress->getDeliveryDate()) {
            $orderShippingAddress = $order->getShippingAddress();
            $orderShippingAddress->setDeliveryDate(
                $shippingAddress->getDeliveryDate()
            )->save();
        }
        if ($shippingAddress->getDeliveryTime()) {
            $orderShippingAddress = $order->getShippingAddress();
            $orderShippingAddress->setDeliveryTime(
                $shippingAddress->getDeliveryTime()
            )->save();
        }

        return $this;
    }
}
