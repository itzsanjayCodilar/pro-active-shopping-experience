<?php

namespace Codilar\ProShopping\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class for configuration
 */
class Configuration
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
       private ScopeConfigInterface $scopeConfig
    ) {
    }
}
