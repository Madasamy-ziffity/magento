<?php

namespace Thecoachsmb\Mymodule\Setup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 *
 * @package Thecoachsmb\Mymodule\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * Creates sample articles
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $conn = $setup->getConnection();
        $tableName = $setup->getTable('thecoachsmb_article');

        $data = [
            [
                'title' => 'How to create table in Magento2',
                'content' => 'Content of the first post.',
            ],
            [
                'title' => 'How to insert data in table of Magento2',
                'content' => 'Content of the second post.',
            ],
        ];
        $conn->insertMultiple($tableName, $data);
        $setup->endSetup(); } }