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

class PromotionProducts implements HttpPostActionInterface
{
    public function __construct(
        private RequestInterface $request,
        private JsonFactory $jsonFactory,
        private SessionFactory $customerSessionFactory,
        private ProductRecommendation $productRecommendation
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
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info("Calling my funcation");
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
