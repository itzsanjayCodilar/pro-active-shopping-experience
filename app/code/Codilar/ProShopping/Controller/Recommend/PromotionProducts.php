<?php

namespace Codilar\ProShopping\Controller\Recommend;

use Codilar\ProShopping\Model\recommendation\ProductRecommendation;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Future code
 */
class PromotionProducts implements HttpPostActionInterface
{
    /**
     * @param RequestInterface $request
     * @param JsonFactory $jsonFactory
     * @param SessionFactory $customerSessionFactory
     * @param ProductRecommendation $productRecommendation
     */
    public function __construct(
        private RequestInterface $request,
        private JsonFactory $jsonFactory,
        private SessionFactory $customerSessionFactory,
        private ProductRecommendation $productRecommendation
    ) {
    }

    /**
     * Execute action based on request and return result
     * Future code
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        $customerSession = $this->customerSessionFactory->create();
        $customer = $customerSession->getCustomer();
        if (!empty($customer->getId())) {
            $productsSearchResult = $this->productRecommendation->getPromotinalProducts($customer);
        } else {
            $productsSearchResult = $this->productRecommendation->getPromotinalProducts();
        }
        $productArr = [];
        if (count($productsSearchResult->getItems()) > 0) {
            foreach ($productsSearchResult->getItems() as $item) {
                $productArr[] = [
                    'id' =>$item->getId(),
                    'sku' =>$item->getSku()
                ];
            }
        }
        $jsonResult = json_encode($productArr);
        $result = $this->jsonFactory->create();
        $result->setData(['output' => $jsonResult]);
    }
}
