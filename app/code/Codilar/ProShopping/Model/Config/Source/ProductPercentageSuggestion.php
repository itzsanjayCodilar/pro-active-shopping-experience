<?php

namespace Codilar\ProShopping\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Get percentage options
 */
class ProductPercentageSuggestion implements OptionSourceInterface
{
    /**
     * @inheirtDoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => '10', 'label' => __('10 %')],
            ['value' => '20', 'label' => __('20 %')],
            ['value' => '30', 'label' => __('30 %')],
            ['value' => '40', 'label' => __('40 %')],
            ['value' => '50', 'label' => __('50 %')],
            ['value' => '60', 'label' => __('60 %')],
            ['value' => '70', 'label' => __('70 %')],
            ['value' => '80', 'label' => __('80 %')],
            ['value' => '90', 'label' => __('90 %')],
            ['value' => '100', 'label' => __('100 %')]
        ];
    }
}
