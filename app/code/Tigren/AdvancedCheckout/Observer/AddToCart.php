<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Observer;

use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\CookieSizeLimitReachedException;
use Magento\Framework\Stdlib\Cookie\FailureToSendException;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart;

/**
 * Class AddToCart
 * @package Tigren\AdvancedCheckout\Observer
 * Tigren Solutions <info@tigren.com>
 */
class AddToCart implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;
    /**
     * @var Cart
     */
    private Cart $cart;
    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;
    /**
     * @var RedirectInterface
     */
    protected RedirectInterface $redirect;
    /**
     * @var \Magento\Checkout\Helper\Cart
     */
    protected \Magento\Checkout\Helper\Cart $cartHelper;
    /**
     * @var ResponseFactory
     */
    protected ResponseFactory $responseFactory;
    /**
     * @var ResultFactory
     */
    protected ResultFactory $resultRedirectFactory;
    /**
     * @var PhpCookieManager
     */
    private PhpCookieManager $cookieManager;
    /**
     * @var CookieMetadataFactory
     */
    private CookieMetadataFactory $cookieMetadataFactory;

    /**
     * @param LoggerInterface $logger
     * @param \Magento\Checkout\Helper\Cart $cartHelper
     * @param RedirectInterface $redirect
     * @param ResponseFactory $responseFactory
     * @param CookieMetadataFactory $cookieMetadataFactory
     * @param PhpCookieManager $cookieManager
     * @param ResultFactory $resultFactory
     * @param ProductRepositoryInterface $productRepository
     * @param Cart $cart
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Checkout\Helper\Cart $cartHelper,
        RedirectInterface $redirect,
        ResponseFactory $responseFactory,
        CookieMetadataFactory $cookieMetadataFactory,
        PhpCookieManager $cookieManager,
        ResultFactory $resultFactory,
        ProductRepositoryInterface $productRepository,
        Cart $cart,
    ) {
        $this->logger = $logger;
        $this->cartHelper = $cartHelper;
        $this->productRepository = $productRepository;
        $this->cart = $cart;
        $this->redirect = $redirect;
        $this->responseFactory = $responseFactory;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->cookieManager = $cookieManager;
        $this->resultRedirectFactory = $resultFactory;
    }

    /**
     * @throws NoSuchEntityException
     * @throws FailureToSendException
     * @throws CookieSizeLimitReachedException
     * @throws InputException
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        $attributeCode = 'allow_multi_order';
        $productId = $observer->getProduct()->getId();
        $product = $this->productRepository->getById($productId);
        $attributeValue = $product->getData($attributeCode);

        foreach ($this->cart->getItems() as $item) {
            if ($item->getProduct()->getId() == $productId && $attributeValue == 0) {
                $cookieMetadata = $this->cookieMetadataFactory
                    ->createPublicCookieMetadata()
                    ->setPath('/')
                    ->setHttpOnly(false)
                    ->setDurationOneYear();
                $this->cookieManager->setPublicCookie('redirect_triggered', '1', $cookieMetadata);
                throw new \Magento\Framework\Exception\LocalizedException(__('This product is not allowed to be multi-ordered'));
            }
        }

        return $this;
    }
}
