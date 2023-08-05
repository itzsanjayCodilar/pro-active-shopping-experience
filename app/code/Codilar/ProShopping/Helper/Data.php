<?php

namespace Codilar\ProShipping\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const CP_CONTACT_ENABLE = 'contactus/active_display/enabled_contactus';
    const CP_PAGE_LINK = 'contactus/active_display/contact_link';
    const PP_POPUP_ENABLE = 'contactus/popup_display/enabled_popup';
    const PP_POPUP_POSITION = 'contactus/popup_display/popup_view';

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    public function getFrontName()
    {
        if ($this->isContactEnabled()) {
            if ($this->pagelink()=='') {
                return 'contactus/front/index';
            } else {
                return $this->pagelink();
            }
        } else {
            return 'contact';
        }
    }

    public function isContactEnabled()
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
