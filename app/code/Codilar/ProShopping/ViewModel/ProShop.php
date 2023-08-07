<?php

namespace Codilar\ProShopping\ViewModel;

use Codilar\ProShopping\Model\Configuration;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProShop implements ArgumentInterface
{
    /**
     * Pro shopping ui position
     */
    private const POP_POSITION = "pro_popup/popup_display/popup_view";
    /**
     * category url
     */
    private const CATEGORY_URL = "pro_shopping/Recommend/GetCategories";
    /**
     * get products by category id
     */
    private const GET_PRODUCT_BY_CATEGORY_URL = "pro_shopping/Recommend/ProductListByCategory";
    /**
     * welcome message
     */
    private const WELCOME_MESSAGE = "pro_popup/welcome_message_group/message";

    /**
     * Welcome to action message
     */
    private const WELCOME_ACTION_MESSAGE = "pro_popup/welcome_message_group/confirm_message";

    /**
     * @param Configuration $configuration
     */
    public function __construct(
        private Configuration $configuration
    ) {
    }

    /**
     * Get product category url
     *
     * @return string
     */
    public function getProductByCategoryUrl(): string
    {
        return self::GET_PRODUCT_BY_CATEGORY_URL;
    }

    /**
     * Get Welcome Message
     *
     * @return string
     */
    public function getWelcomeMessage(): string
    {
        return $this->configuration->getConfigValue(self::WELCOME_MESSAGE);
    }

    /**
     * Get Action Welcome Message
     *
     * @return string
     */
    public function getActionWelcomeMessage(): string
    {
        return $this->configuration->getConfigValue(self::WELCOME_ACTION_MESSAGE);
    }

    /**
     * Get Category url
     *
     * @return string
     */
    public function getCategoryUrl(): string
    {
        return self::CATEGORY_URL;
    }

    /**
     * Is Welcome message enable
     *
     * @return bool
     */
    public function isWelcomeMessage(): bool
    {
        return $this->configuration->isWelcomeMessageEnable();
    }

    public function isProActionUiEnabled()
    {
        return $this->configuration->isProActionUiEnabled();
    }

    /**
     * Get Pop up position
     *
     * @return mixed|null
     */
    public function getPopUpPosition()
    {
        return $this->configuration->getConfigValue(self::POP_POSITION);
    }
}
