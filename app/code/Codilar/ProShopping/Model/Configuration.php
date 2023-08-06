<?php

namespace Codilar\ProShopping\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class for configuration
 */
class Configuration
{
    const CP_CONTACT_ENABLE = 'proshopping/active_display/enabled_proshopping';
    const CP_PAGE_LINK = 'proshopping/active_display/contact_link';
    const PP_POPUP_ENABLE = 'proshopping/popup_display/enabled_popup';
    const PP_POPUP_POSITION = 'proshopping/popup_display/popup_view';
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
       private ScopeConfigInterface $scopeConfig
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

}
