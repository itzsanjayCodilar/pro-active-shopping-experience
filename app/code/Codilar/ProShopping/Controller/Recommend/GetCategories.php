<?php

namespace Codilar\ProShopping\Controller\Recommend;

use Magento\Catalog\Api\CategoryListInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class GetCategories implements HttpPostActionInterface
{
    public function __construct(
        private CategoryListInterface $categoryList,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private JsonFactory $jsonFactory,
        private FilterBuilder $filterBuilder

    ) {
    }

    public function execute()
    {
        $categories = [];
        $filter = $this->filterBuilder->setField("entity_id")
            ->setValue([1,2])
            ->setConditionType("nin")->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters([$filter])
            ->create();
        $categoryList = $this->categoryList->getList($searchCriteria);

        if (count($categoryList->getItems()) > 0) {
            foreach ($categoryList->getItems() as $item) {
                $categories [] = [
                    "id" =>$item->getId(),
                    "name" =>$item->getName()
                ];
            }
        }
        $jsonResult = json_encode($categories);
        $result = $this->jsonFactory->create();
        $result->setData(['output' => $jsonResult]);
        return $result;
    }
}
