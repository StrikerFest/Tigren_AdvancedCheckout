<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

/**
 * Class CheckOrder
 * @package Tigren\AdvancedCheckout\Plugin
 * Tigren Solutions <info@tigren.com>
 */
class CheckOrder
{
    /**
     * @var OrderFactory
     */
    protected OrderFactory $orderFactory;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $orderCollectionFactory;

    /**
     * @param OrderFactory $orderFactory
     * @param CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        OrderFactory $orderFactory,
        CollectionFactory $orderCollectionFactory,
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * @param OrderManagementInterface $subject
     * @param OrderInterface $order
     *
     * @return OrderInterface[]
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws LocalizedException
     */
    public function beforePlace(
        OrderManagementInterface $subject,
        OrderInterface $order
    ): array {
        $customerId = $order->getCustomerId();

        $orderCollection = $this->orderCollectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('state', Order::STATE_NEW);

        if ($orderCollection->getSize() > 0) {
            throw new LocalizedException(__('You have an order that is not complete. Please wait to complete the order before creating a new order.'));
        }

        return [$order];
    }
}
