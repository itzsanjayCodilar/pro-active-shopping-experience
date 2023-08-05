<?php

namespace Codilar\ProShopping\Controller\Recommend;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;

class InitialProductRefer implements HttpPostActionInterface
{
    public function __construct(
        private RequestInterface $request,
        private JsonFactory $jsonFactory,
        private CollectionFactory $collectionFactory
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
        $baseUrl = "http://hackathon.local/pub/media/catalog/product/";
        $id = $this->request->getParam('categoryId');
        $productCollection = $this->collectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addCategoriesFilter(['eq' => $id]);
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
