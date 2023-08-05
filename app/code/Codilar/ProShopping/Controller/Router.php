<?php
namespace Codilar\ProShopping\Controller;

use Codilar\ProShopping\Model\Configuration;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected $actionFactory;
    /**
     * Response
     *
     * @var ResponseInterface
     */
    protected $_response;

    /**
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     * @param Configuration $myModuleHelper
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        Configuration $myModuleHelper
    ) {
        $this->actionFactory = $actionFactory;
        $this->_mymoduleHelper = $myModuleHelper;
        $this->_response = $response;
    }
    /**
     * Validate and Match
     *
     * @param RequestInterface $request
     * @return ActionInterface
     */
    public function match(RequestInterface $request)
    {

        $identifier = trim($request->getPathInfo(), '/');


        if (strpos($identifier, $this->_mymoduleHelper->pagelink()) !== false) {
            /*
             * We must set module, controller path and action name for our controller class(Controller/Test/Test.php)
             */
            $request->setModuleName('proshopping')->setControllerName('front')->setActionName('index');
        } else {
            //There is no match
            return;
        }
        /*
         * We have match and now we will forward action
         */
        return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );
    }
}
