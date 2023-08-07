<?php

namespace Codilar\ProShopping\Model\recommendation;

use Codilar\ProShopping\Model\Configuration;
use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Model\Customer;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use  Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Wishlist\Model\Wishlist;

class ProductRecommendation
{
    private const PRODUCT_LISTING_LIMIT = "pro_core/pro_core_config/product_limit";
    private const IS_WISHLIST_PRODUCT_ENABLE = "pro_core/pro_login_customer/is_login_wishlist_allow";

    /**
     * @param Configuration $configuration
     * @param Wishlist $wishlist
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param ProductRepository $productRepository
     */
    public function __construct(
        private Configuration $configuration,
        private Wishlist $wishlist,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private FilterBuilder $filterBuilder,
        private FilterGroupBuilder $filterGroupBuilder,
        private ProductRepository $productRepository
    ) {
    }

    /**
     * Get promotional products
     * Future code
     *
     * @param Customer $customer
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getPromotinalProducts(Customer $customer = null)
    {
        $pageLimit = $this->configuration->getConfigValue(self::PRODUCT_LISTING_LIMIT);
        if ($customer !== null) {
            $skus = $this->configuration->getPromotialProductsConfig(false);
        } else {
            $wishListSku = [];
            if ($this->configuration->getConfigValue(self::IS_WISHLIST_PRODUCT_ENABLE)) {
                $wishListSku = $this->getWishListProductByCustomerId($customer);
            }
            $promoSkus = $this->configuration->getPromotialProductsConfig();
            $skus = array_merge($promoSkus, $wishListSku);
        }
        $skusFilter = $this->filterBuilder
             ->setField("sku")
            ->setConditionType("in")
            ->setValue($skus)->create();
        $searchCriteria = $this->searchCriteriaBuilder->addFilters([$skusFilter])
            ->setPageSize($pageLimit)->create();
        return $this->productRepository->getList($searchCriteria);
    }

    /**
     * Get wishlist product by customer id
     * Future code
     *
     * @param $customerId
     * @return array
     */
    private function getWishListProductByCustomerId($customerId)
    {
        try {
            $wishListItems = $this->wishlist->loadByCustomerId($customerId)?->getItemCollection();
            if (!empty($wishListItems)) {
                $productSkus = [];
                foreach ($wishListItems as $item) {
                    $productSkus [] = $item->getProduct()->getSku();
                }
                return $productSkus;
            }
            return [];
        } catch (NoSuchEntityException $e) {
            return [];
        }
    }
}
