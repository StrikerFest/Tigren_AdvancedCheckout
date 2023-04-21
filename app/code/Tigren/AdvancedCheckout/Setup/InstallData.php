<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Setup;

use Magento\Customer\Setup\CustomerSetup;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Validator\ValidateException;

/**
 * Install Data
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private CustomerSetupFactory $customerSetupFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context): void
    {
        $this->addDeliveryDateAttribute($setup);
        $this->addDeliveryTimeAttribute($setup);

    }

    /**
     * Add the address delivery_date attribute
     *
     * @param ModuleDataSetupInterface $setup
     * @return void
     */
    protected function addDeliveryDateAttribute(ModuleDataSetupInterface $setup): void
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        if (!$customerSetup->getAttributeId('customer_address', 'delivery_date')) {
            try {
                $customerSetup->addAttribute('customer_address', 'delivery_date', [
                    'type' => 'varchar',
                    'label' => 'Delivery Date',
                    'input' => 'hidden',
                    'required' => false,
                    'visible' => true,
                    'system' => 0,
                    'visible_on_front' => false,
                    'sort_order' => 101,
                    'position' => 101
                ]);
            } catch (LocalizedException $e) {

            } catch (ValidateException $e) {

            }
        }

    }

    /**
     * Add the address delivery_time attribute
     *
     * @param ModuleDataSetupInterface $setup
     * @return void
     */
    protected function addDeliveryTimeAttribute(ModuleDataSetupInterface $setup): void
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        if (!$customerSetup->getAttributeId('customer_address', 'delivery_time')) {
            try {
                $customerSetup->addAttribute('customer_address', 'delivery_time', [
                    'type' => 'varchar',
                    'label' => 'Delivery Time',
                    'input' => 'hidden',
                    'required' => false,
                    'visible' => true,
                    'system' => 0,
                    'visible_on_front' => false,
                    'sort_order' => 101,
                    'position' => 101
                ]);
            } catch (LocalizedException $localizedException) {

            } catch (ValidateException $validateException) {

            }
        }

    }

}
