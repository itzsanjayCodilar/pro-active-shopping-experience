<?php

namespace Codilar\ProShopping\Block;

use Codilar\ProShopping\Model\Configuration;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Information;

class ShoppingBlock extends Template
{
    /**
     * @var Information
     */
    protected Information $_storeInfo;

    /**
     * @var Configuration
     */
    protected Configuration $myModuleHelper;

    /**
     * @param Context $context
     * @param Configuration $myModuleHelper
     * @param Information $storeInfo
     * @param array $data
     */
    public function __construct(
        Context $context,
        Configuration $myModuleHelper,
        Information $storeInfo,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_mymoduleHelper = $myModuleHelper;
        $this->_storeInfo = $storeInfo;
        $this->_isScopePrivate = true;
    }

    /**
     * @return $this|ShoppingBlock
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getUrl(
            '*/*/*',
            [
                    '_current' => true,
                    '_use_rewrite' => true
            ]
        ) == $this->getUrl(
            'ProShopping/front/index',
            [
                    '_secure' => true
            ]
        )
        ) {
            $this->pageConfig->getTitle()->set($this->_mymoduleHelper->metatittle());
            $this->pageConfig->setKeywords($this->_mymoduleHelper->metakeyword());
            $this->pageConfig->setDescription($this->_mymoduleHelper->metadescription());
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function isimage()
    {
        return $this->_mymoduleHelper->isNewsImageEnabled();
    }

    /**
     * @return mixed
     */
    public function isContactEnabled()
    {
        return $this->_mymoduleHelper->isContactEnabled();
    }

    /**
     * @return mixed
     */
    public function isPopupEnabled()
    {
        return $this->_mymoduleHelper->isPopupEnabled();
    }

    /**
     * @return mixed
     */
    public function popupposition()
    {
        return $this->_mymoduleHelper->popupposition();
    }
}
