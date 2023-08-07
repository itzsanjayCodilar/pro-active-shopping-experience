<?php

namespace Codilar\ProShopping\ViewModel;

use Codilar\ProShopping\Model\Configuration;
use Exception;
use Magento\Catalog\Api\CategoryListInterface;
use Magento\Catalog\Api\Data\CategorySearchResultsInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProShop implements ArgumentInterface
{
    /**
     * category url
     */
    private const CATEGORY_URL = "pro_shopping/Recommend/GetCategories";

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var CategoryListInterface
     */
    private CategoryListInterface $categoryList;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $productRepository;

    /**
     * @var Configuration
     */
    private Configuration $configuration;

    /**
     * @param CategoryListInterface $categoryList
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CollectionFactory $productRepository
     * @param Configuration $configuration
     */
    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $productRepository,
        Configuration $configuration
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
        $this->configuration = $configuration;
    }

    /**
     * Fetch all Category list
     *
     * @return CategorySearchResultsInterface
     * @throws Exception
     */
    public function getAllSystemCategory()
    {
        $categoryList = [];
        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $categoryList = $this->categoryList->getList($searchCriteria);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $categoryList;
    }

    /**
     * Get product category url
     *
     * @return string
     */
    public function getProductCategoryUrl()
    {
        return "pro_shopping/Recommend/ProductListByCategory";
    }

    /**
     * Get recommended product
     *
     * @return array
     */
    public function getRecommendedProduct()
    {
        $collection = $this->productRepository->create();
        $collection->addAttributeToSelect(['name', 'price', 'image']); // Select only Name, Price, and Image attributes
        $products = $collection->setPageSize(3); // Fetching only 3 products

        $data = [];
        foreach ($products as $product) {
            $name = $product->getName(); // Get Name attribute
            $price = $product->getPrice();
            $image = $product->getImage();

            // Add product data to the $data array
            $data[] = [
                'name' => $name,
                'price' => $price,
                'image' => $image
            ];
        }
        return $data;
    }

    /**
     * get initial product refer url
     *
     * @return string
     */
    public function initialProductReferUrl()
    {
        return "pro_shopping/Recommend/PromotionProducts";
    }

    /**
     * Get Welcome Message
     *
     * @return string
     */
    public function getWelcomeMessage(): string
    {
        return $this->configuration->getWelcomeMessage();
    }

    /**
     * Get Welcome Message
     *
     * @return string
     */
    public function getConfirmMessage(): string
    {
        return $this->configuration->getConfirmationMessage();
    }

    /**
     * Get Welcome Message Enabled
     *
     * @return bool
     */
    public function getWelcomeMessageEnabled(): bool
    {
        return $this->configuration->getWelcomeMessageEnabled();
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
}
