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
    const POPUP_POSITION = 'pro_popup/popup_display/popup_view';

    private const INITIAL_LOGIN_SKUS = "pro_core/pro_login_customer/initial_product_sku_login";
    private const INITIAL_GUEST_SKUS = "pro_core/pro_guest_customer/initial_product_sku_guest";
    private const IS_PRO_UI_ENABLE = "pro_popup/popup_display/enabled_popup";
    private const IS_WELCOME_MESSAGE_ENABLE = "pro_popup/welcome_message_group/welcome_message_enabled";

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private StoreManagerInterface $storeManager
    ) {
    }

    /**
     * Get the initial skus
     * future code
     *
     * @param $isGuest
     * @param $store
     * @return array|string[]
     */
    public function getPromotialProductsConfig($isGuest = true, $store = null)
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
     * Get the configuration value
     *
     * @param $configPath
     * @param $store
     * @return mixed|null
     */
    public function getConfigValue($configPath, $store = null)
    {
        if (empty($store)) {
            try {
                $store = $this->storeManager->getStore()?->getId();
            } catch (NoSuchEntityException $e) {
                $store = 0;
            }
        }
        return $this->scopeConfig->getValue($configPath, ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * is pro action ui enable
     *
     * @param $store
     * @return bool
     */
    public function isProActionUiEnabled($store = null): bool
    {
        if (empty($store)) {
            try {
                $store = $this->storeManager->getStore()?->getId();
            } catch (NoSuchEntityException $e) {
                $store = 0;
            }
        }
        return $this->scopeConfig->isSetFlag(
            self::IS_PRO_UI_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * is welcome enable
     *
     * @param $store
     * @return bool
     */
    public function isWelcomeMessageEnable($store = null): bool
    {
        if (empty($store)) {
            try {
                $store = $this->storeManager->getStore()?->getId();
            } catch (NoSuchEntityException $e) {
                $store = 0;
            }
        }
        return $this->scopeConfig->isSetFlag(
            self::IS_WELCOME_MESSAGE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
