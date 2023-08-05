<?php

namespace Codilar\ProShopping\Controller\Front;

class Index extends \Codilar\ProShopping\Controller\Front
{

    public function execute()
    {

        //echo "news module";
        $this->_view->loadLayout();

        //$this->_view->getLayout()->initMessages();

        $this->_view->renderLayout();
    }
}
