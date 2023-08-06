<?php

namespace Codilar\ProShopping\Model\recommendation;

use Codilar\ProShopping\Model\Configuration;
use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Model\Customer;
use Magento\Framework\Api\FilterBuilder;
use  Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Wishlist\Model\Wishlist;

class ProductRecommendation
{
    private const PRODUCT_LISTING_LIMIT = "pro_core/pro_core_config/product_limit";

    public function __construct(
        private Configuration $configuration,
        private Wishlist $wishlist,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private FilterBuilder $filterBuilder,
        private ProductRepository $productRepository
    ) {
    }

    /**
     * @param Customer $customer
     * @return void
     */
    public function getProductsForLogInCustomer(Customer $customer)
    {
        $searchCriteria  = $this->searchCriteriaBuilder->create();
        $actualLimit = $this->getLimitForProductList(true);
        $searchCriteria->setPageSize($actualLimit);
        $result = $this->productRepository->getList($searchCriteria);
        $productLimit = $this->configuration->getConfigValue(self::PRODUCT_LISTING_LIMIT);
        $wishListProducts = $this->getWishListProductByCustomerId($customer->getId());
    }

    private function getWishListProductByCustomerId($customerId)
    {
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
