<?php

namespace Codilar\ProShopping\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ListMode implements OptionSourceInterface
{
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => __('Left')],
            ['value' => '1', 'label' => __('Right')],

        ];
    }
}
