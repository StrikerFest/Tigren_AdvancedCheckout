<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Add the new column
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $installer = $setup;
        $installer->startSetup();

        $this->addDeliveryDateColumn($setup);

        $installer->endSetup();
    }

    /**
     * Add the column named delivery_date
     *
     * @param SchemaSetupInterface $setup
     *
     * @return void
     */
    private function addDeliveryDateColumn(SchemaSetupInterface $setup): void
    {
        $deliveryDate = [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
            'default' => NULL,
            'nullable' => true,
            'comment' => 'Delivery Date'
        ];

        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order_address'),
            'delivery_date',
            $deliveryDate
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('quote_address'),
            'delivery_date',
            $deliveryDate
        );

        $deliveryTime = [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'default' => NULL,
            'nullable' => true,
            'comment' => 'Delivery Time'
        ];

        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order_address'),
            'delivery_time',
            $deliveryTime
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('quote_address'),
            'delivery_time',
            $deliveryTime
        );


    }
}
