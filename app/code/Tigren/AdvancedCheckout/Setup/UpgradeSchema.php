<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright  Copyright (c)  2023.  Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Zend_Db_Exception;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @throws Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $salesOrderTable = $setup->getTable('sales_order');

            $deliveryTable = $setup->getConnection()->newTable(
                $setup->getTable('delivery_timeframe')
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->addColumn(
                'order_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Order ID'
            )->addColumn(
                'delivery_start_time',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Delivery Start Time'
            )->addColumn(
                'delivery_end_time',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Delivery End Time'
            )->addColumn(
                'delivery_date',
                Table::TYPE_DATE,
                null,
                ['nullable' => true],
                'Delivery Date'
            )->addColumn(
                'delivery_day_of_week',
                Table::TYPE_TEXT,
                20,
                ['nullable' => true],
                'Delivery Day of Week'
            )->addForeignKey(
                $setup->getFkName('delivery_timeframe', 'order_id', $salesOrderTable, 'entity_id'),
                'order_id',
                $salesOrderTable,
                'entity_id',
                Table::ACTION_CASCADE
            )->setComment(
                'Custom Table for Delivery Information'
            );

            $setup->getConnection()->createTable($deliveryTable);
        }

        $setup->endSetup();
    }
}
