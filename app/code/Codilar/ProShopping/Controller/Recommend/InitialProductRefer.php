<?php

namespace Codilar\ProShopping\Controller\Recommend;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Codilar\ProShopping\Model\recommendation\ProductRecommendation;

class InitialProductRefer implements HttpPostActionInterface
{
    public function __construct(
        private RequestInterface $request,
        private JsonFactory $jsonFactory,
        private CollectionFactory $collectionFactory,
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
//        $this->productRecommendation->getProductsForLogInCustomer($customer);

        $productArr = [];

        $jsonResult = json_encode($productArr);
        $result = $this->jsonFactory->create();
        $result->setData(['output' => $jsonResult]);
    }
}
