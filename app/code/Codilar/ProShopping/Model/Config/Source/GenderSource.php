<?php

namespace Codilar\ProShopping\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class GenderSource extends AbstractSource
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Male'), 'value' => 'male'],
                ['label' => __('Female'), 'value' => 'female'],
                ['label' => __('Both'), 'value' => 'both']
                // Add more options as needed
            ];
        }
        return $this->_options;
    }
}
