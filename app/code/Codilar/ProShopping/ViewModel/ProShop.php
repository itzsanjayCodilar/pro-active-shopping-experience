<?php

namespace Codilar\ProShopping\ViewModel;

use Exception;
use Magento\Catalog\Api\CategoryListInterface;
use Magento\Catalog\Api\Data\CategorySearchResultsInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProShop implements ArgumentInterface
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CategoryListInterface
     */
    private $categoryList;

    /**
     * @var CollectionFactory
     */
    private $productRepository;

    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $productRepository
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
    }

    /**
     * Fetch all Category list
     *
     * @return CategorySearchResultsInterface
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

    public function getProductCategoryUrl()
    {
        return "pro_shopping/Recommend/ProductListByCategory";
    }

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
        return "pro_shopping/Recommend/InitialProductRefer";
    }
}
