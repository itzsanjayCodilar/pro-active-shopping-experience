<?php

namespace Codilar\ProShopping\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class for configuration
 */
class Configuration
{
    const CP_CONTACT_ENABLE = 'proshopping/active_display/enabled_proshopping';
    const CP_PAGE_LINK = 'proshopping/active_display/contact_link';
    const PP_POPUP_ENABLE = 'proshopping/popup_display/enabled_popup';
    const PP_POPUP_POSITION = 'proshopping/popup_display/popup_view';

    private const INITIAL_LOGIN_SKUS = "pro_core/pro_login_customer/initial_product_sku_login";
    private const INITIAL_GUEST_SKUS = "pro_core/pro_guest_customer/initial_product_sku_guest";
    private const IS_PRO_SHOPPING_ENABLE = "pro_core/pro_core_config/is_pro_enable";

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private StoreManagerInterface $storeManager
    ) {
    }

    public function getFrontName()
    {
        if ($this->isShoppingEnabled()) {
            if ($this->pagelink()=='') {
                return 'proshopping/front/index';
            } else {
                return $this->pagelink();
            }
        } else {
            return 'contact';
        }
    }
    public function isShoppingEnabled()
    {
        return $this->scopeConfig->getValue(
            self::CP_CONTACT_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }
    public function pagelink()
    {
        return $this->scopeConfig->getValue(
            self::CP_PAGE_LINK,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function isPopupEnabled()
    {
        return $this->scopeConfig->getValue(
            self::PP_POPUP_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function popupposition()
    {
        return $this->scopeConfig->getValue(
            self::PP_POPUP_POSITION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get the initial skus
     *
     * @param $isGuest
     * @param $store
     * @return array|string[]
     */
    public function getInitialProductSkuForGuest($isGuest = true, $store = null)
    {
        $skus = [];
        if (empty($store)) {
            try {
                $store = $this->storeManager->getStore()?->getId();
            } catch (NoSuchEntityException $e) {
                return $skus;
            }
        }
        if ($isGuest) {
            $configValue = $this->scopeConfig->getValue(self::INITIAL_GUEST_SKUS, ScopeInterface::SCOPE_STORE, $store);
        } else {
            $configValue =  $this->scopeConfig->getValue(self::INITIAL_LOGIN_SKUS, ScopeInterface::SCOPE_STORE, $store);
        }
        if (!empty($configValue)) {
            $skus = explode(",", $configValue);
        }
        return $skus;
    }

    /**
     * Is pro shopping enable
     *
     * @param $store
     * @return bool
     */
    public function isProShoppingEnable($store = null)
    {
        if (empty($store)) {
            try {
                $store = $this->storeManager->getStore()?->getId();
            } catch (NoSuchEntityException $e) {
                return false;
            }
        }
        return $this->scopeConfig->isSetFlag(self::IS_PRO_SHOPPING_ENABLE, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Get the configuration value
     *
     * @param $configPath
     * @param $store
     * @return mixed|null
     */
    public function getConfigValue($configPath, $store = null, )
    {
        if (empty($store)) {
            try {
                $store = $this->storeManager->getStore()?->getId();
            } catch (NoSuchEntityException $e) {
                return null;
            }
        }
        return $this->scopeConfig->getValue($configPath, ScopeInterface::SCOPE_STORE, $store);
    }
}
