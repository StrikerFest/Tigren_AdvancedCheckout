<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */


namespace Tigren\AdvancedCheckout\Plugin;

use Magento\Customer\Model\ResourceModel\AddressRepository;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Model\AddressFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Customer\Api\Data\RegionInterfaceFactory;

/**
 * Class GuestToCustomer
 * @package Tigren\AdvancedCheckout\Plugin
 * Tigren Solutions <info@tigren.com>
 */
class GuestToCustomer
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;
    /**
     * @var AccountManagementInterface
     */
    protected AccountManagementInterface $accountManagement;

    /**
     * @var CustomerRepositoryInterface
     */
    protected CustomerRepositoryInterface $customerRepository;

    /**
     * @var CustomerInterfaceFactory
     */
    protected CustomerInterfaceFactory $customerFactory;

    /**
     * @var AddressInterfaceFactory
     */
    protected AddressInterfaceFactory $addressFactory;

    /**
     * @var AddressFactory
     */
    protected AddressFactory $addressModelFactory;
    /**
     * @var AddressRepository
     */
    private AddressRepository $addressRepository;
    /**
     */
    private RegionInterfaceFactory $regionFactory;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param AccountManagementInterface $accountManagement
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterfaceFactory $customerFactory
     * @param AddressInterfaceFactory $addressFactory
     * @param AddressFactory $addressModelFactory
     * @param AddressRepository $addressRepository
     * @param RegionInterfaceFactory $regionFactory
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        AccountManagementInterface $accountManagement,
        CustomerRepositoryInterface $customerRepository,
        CustomerInterfaceFactory $customerFactory,
        AddressInterfaceFactory $addressFactory,
        AddressFactory $addressModelFactory,
        AddressRepository $addressRepository,
        RegionInterfaceFactory $regionFactory,
    ) {
        $this->orderRepository = $orderRepository;
        $this->accountManagement = $accountManagement;
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->addressFactory = $addressFactory;
        $this->addressModelFactory = $addressModelFactory;
        $this->addressRepository = $addressRepository;
        $this->regionFactory = $regionFactory;
    }

    /**
     * @param OrderManagementInterface $subject
     * @param $result
     * @param OrderInterface $order
     * @return mixed
     */
    public function afterPlace(
        OrderManagementInterface $subject,
        $result,
        OrderInterface $order
    ): mixed {
        if ($order->getCustomerId() === null) {
            $shippingAddress = $order->getShippingAddress();

            if ($shippingAddress !== null) {
                $customerEmail = $shippingAddress->getEmail();

                if ($customerEmail !== null) {
                    try {
                        $customer = $this->customerFactory->create();
                        $customer->setEmail($customerEmail);
                        $customer->setFirstname($shippingAddress->getFirstname());
                        $customer->setLastname($shippingAddress->getLastname());

                        $this->accountManagement->createAccount($customer, 'Dummy@123');

                        $address = $this->addressFactory->create();
                        $address->setCustomerId($customer->getId());
                        $address->setFirstname($shippingAddress->getFirstname());
                        $address->setLastname($shippingAddress->getLastname());

                        $address->setStreet($shippingAddress->getStreet());
                        $address->setCity($shippingAddress->getCity());
                        $address->setCountryId($shippingAddress->getCountryId());
                        $address->setPostcode($shippingAddress->getPostcode());

                        $region = $this->regionFactory->create();
                        $region->setRegionId($shippingAddress->getRegionId());
                        $region->setRegionCode($shippingAddress->getRegionCode());
                        $region->setRegion($shippingAddress->getRegion());

                        $address->setRegion($region);
                        $address->setTelephone($shippingAddress->getTelephone());

                        $this->addressRepository->save($address);

                        $order->setCustomerId($customer->getId());
                        $this->orderRepository->save($order);

                    } catch (LocalizedException $e) {
                    }
                }
            }
        }
        return $result;
    }
}
