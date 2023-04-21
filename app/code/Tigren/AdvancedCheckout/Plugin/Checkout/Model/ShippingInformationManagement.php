<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Plugin\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;

class ShippingInformationManagement
{
    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ): void {
        $shippingAddress = $addressInformation->getShippingAddress();
        $shippingExtensionAttributes = $shippingAddress->getExtensionAttributes();

        if (!empty($shippingExtensionAttributes)) {
            $shippingExtensionAttributes = $shippingAddress->getExtensionAttributes();
            if (!empty($shippingExtensionAttributes)) {
                $shippingAddress->setDeliveryDate($shippingExtensionAttributes->getDeliveryDate());
                $shippingAddress->setDeliveryTime($shippingExtensionAttributes->getDeliveryTime());
            }
        }
    }
}
