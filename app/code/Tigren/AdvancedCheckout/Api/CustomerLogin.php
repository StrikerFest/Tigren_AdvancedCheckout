<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Api;

use Exception;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Encryption\EncryptorInterface;

/**
 * Class CustomerLogin
 * @package Tigren\AdvancedCheckout\Api
 * Tigren Solutions <info@tigren.com>
 */
class CustomerLogin implements CustomerLoginInterface
{
    /**
     * @var EncryptorInterface
     */
    protected EncryptorInterface $encryptor;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;
    /**
     * @var CustomerFactory
     */
    private CustomerFactory $customerFactory;

    /**
     * CustomerLogin constructor.
     * @param CustomerFactory $customerFactory
     * @param StoreManagerInterface $storeManager
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        EncryptorInterface $encryptor,
    ) {
        $this->customerFactory = $customerFactory;
        $this->storeManager = $storeManager;
        $this->encryptor = $encryptor;
    }

    /**
     * {@inheritdoc}
     */
    public function login($email, $password): ?string
    {
        try {
            $customer = $this->customerFactory->create();
            $customer->setWebsiteId($this->getWebsiteId());
            $customer->loadByEmail($email);

            if ($customer->getId() && $customer->validatePassword($password)) {
                return $this->generateToken($customer->getId());
            } else {
                throw new AuthenticationException(__('Invalid email or password.'));
            }

        } catch (NoSuchEntityException $e) {
            throw new InputException(__('Invalid email or password.'));

        } catch (LocalizedException $e) {
            throw new AuthenticationException(__('Invalid email or password.'));

        } catch (Exception $e) {
            throw new AuthenticationException(__('An error occurred while logging in.'));

        }
    }

    /**
     * @return int
     * @throws NoSuchEntityException
     */
    public function getWebsiteId(): int
    {
        $storeId = $this->storeManager->getStore()->getId();
        return $this->storeManager->getStore($storeId)->getWebsiteId();
    }

    /**
     * @param $customerId
     * @return string
     */
    public function generateToken($customerId): string
    {
        $secretKey = 'this_key_is_bruh';
        $timestamp = time();
        $data = $customerId . $timestamp . $secretKey;
        return $this->encryptor->encrypt($data);
    }
}
