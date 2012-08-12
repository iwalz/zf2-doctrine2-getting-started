<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel,
Zend\View\Renderer\PhpRenderer,
Zend\View\Resolver;


class ProductController extends AbstractActionController
{
    public function createAction()
    {
    	$view = new ViewModel();
    	$request = $this->getRequest();
    	
    	if($request->isPost())
    	{
			$entityManager = $this->getEvent()->getParam("entityManager");
    		
    		$strProduct = $request->getPost()->product;
    		$product = new \Product();
    		$product->setName($strProduct);
    		
    		$entityManager->persist($product);
    		$entityManager->flush();
    		
    		$view->setVariable('product', $product);
			$view->setTemplate('application/product/create_post');
    	}
        return $view;
    }
}
