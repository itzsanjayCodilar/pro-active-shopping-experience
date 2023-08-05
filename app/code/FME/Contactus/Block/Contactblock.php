<?php

namespace  FME\Contactus\Block;

use FME\Contactus\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Information;

class Contactblock extends Template
{
    /**
     * @var Information
     */
    protected Information $_storeInfo;

    /**
     * @var Data
     */
    protected Data $myModuleHelper;

    /**
     * @param Context $context
     * @param Data $myModuleHelper
     * @param Information $storeInfo
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $myModuleHelper,
        Information $storeInfo,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_mymoduleHelper = $myModuleHelper;
        $this->_storeInfo = $storeInfo;
        $this->_isScopePrivate = true;
    }

    /**
     * @return $this|Contactblock
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
                'contactus/front/index',
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
