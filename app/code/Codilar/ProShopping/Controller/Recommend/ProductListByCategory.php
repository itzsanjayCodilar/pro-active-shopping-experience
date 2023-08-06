<?php

namespace Codilar\ProShopping\Controller\Recommend;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Get product by category id
 */
class ProductListByCategory implements HttpPostActionInterface
{

    public function __construct(
        private RequestInterface $request,
        private JsonFactory $jsonFactory,
        private CollectionFactory $collectionFactory,
        private StoreManagerInterface $storeManager
    ) {
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        try {
            $baseUrl = $this->storeManager->getStore()?->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                . 'catalog/product';
        } catch (NoSuchEntityException $e) {
            $baseUrl = null;
        }

        $id = $this->request->getParam('categoryId');
        $budgetValue = $this->request->getParam('budget');
        $productCollection = $this->collectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addCategoriesFilter(['eq' => $id]);
        $productCollection->addAttributeToFilter('price', ['lt' => $budgetValue]);
        $products = $productCollection->getItems();
        $productArr = [];
        foreach ($products as $product) {
            $productArr[] = [
                'id' => $product->getId(),
                "sku" => $product->getSku(),
                "image" => $baseUrl . $product->getImage(),
                "price" => $product->getPrice()
            ];
        }
        $jsonResult = json_encode($productArr);
        $result = $this->jsonFactory->create();
        $result->setData(['output' => $jsonResult]);
        return $result;
    }
}
