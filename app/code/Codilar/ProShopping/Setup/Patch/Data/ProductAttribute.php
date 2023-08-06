<?php

namespace Codilar\ProShopping\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Codilar\ProShopping\Model\Config\Source\GenderSource;

class ProductAttribute implements DataPatchInterface
{
    private const ATTRIBUTE_CODE_GENDER = "gender";

    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private EavSetupFactory $eavSetupFactory
    ) {
    }
    public function apply()
    {
        $eavsetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $attributeConfigData = [
            'user_defined' => true,
            'type' => 'text',
            'label' => 'Gender',
            'input' => 'select',
            'source' => GenderSource::class,
            'required' => true,
            'visible' => true,
            'visible_on_front' => true,
            'searchable' => 1,
            'filterable' => 1,
            'comparable' => 0,
            'filterable_in_search' => 1,
            'visible_in_advanced_search' => 1,
            'used_in_product_listing' => 1,
            'is_used_in_grid' => 0,
            'is_filterable_in_grid' => 0,
            'group' => 'General',
            'default' => "both",
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'used_for_sort_by' => 10
            ];
        $eavsetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_GENDER,
            $attributeConfigData
        );
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
