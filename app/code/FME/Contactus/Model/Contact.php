<?php

namespace FME\Contactus\Model;

use Magento\Framework\Model\AbstractModel;

class Contact extends AbstractModel
{
    /**
     * Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Aion Test cache tag
     */
    const CACHE_TAG = 'contactus_contact';

    /**
     * @var string
     */
    protected $_cacheTag = 'contactus_contact';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'contactus_contact';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('FME\Contactus\Model\ResourceModel\Contact');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Prepare item's statuses
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
