<?php

namespace Codilar\ProShopping\Model\recommendation;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Customer\Model\Customer;
use Codilar\ProShopping\Model\Configuration;
use Magento\Framework\Exception\NoSuchEntityException;
use  Magento\Wishlist\Model\Wishlist;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;

class ProductRecommendation
{
    public function __construct(
        private Configuration $configuration,
        private Wishlist $wishlist,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private FilterBuilder $filterBuilder
    ) {
    }

    /**
     * @param Customer $customer
     * @return void
     */
    public function getProductsForLogInCustomer(Customer $customer)
    {
        $productLimit = $this->configuration->getProductLimit();
        $wishListProducts = $this->getWishListProductByCustomerId($customer->getId());
    }
    public function getProductsForGuest()
    {

    }

    private function getWishListProductByCustomerId($customerId)
    {  $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info("Callingg etWishListByCustomerId  ");
        try {
            $wishListItems = $this->wishlist->loadByCustomerId($customerId)?->getItemCollection();
            if (!empty($wishListItems)) {
                $products = [];
                foreach ($wishListItems as $item) {
                    $products [] = $item->getProduct();
                }
                return $products;
            }
            return [];
        } catch (NoSuchEntityException $e) {
            return [];
        }
    }
}
