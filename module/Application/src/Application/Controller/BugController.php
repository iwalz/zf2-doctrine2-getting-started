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
use Zend\View\Model\ViewModel;

class BugController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function closeAction()
    {
    	$view = new ViewModel();
    	$request = $this->getRequest();
    	$entityManager = $this->getEvent()->getParam("entityManager");
    	
    	if($request->isPost())
    	{
    		$bugId = $request->getPost()->bug;
    		$bug = $entityManager->find('Bug', $bugId);
    		$bug->close();
    		$entityManager->flush();
    		$view->setVariable('bug', $bug);
    		$view->setTemplate('application/bug/close_post');
    	}
    	else
    	{
    		$bugs = $entityManager->getRepository('Bug')->findAll();
    		$view->setVariable('bugs', $bugs);
    	}
    	return $view;
    }
    
    public function createAction()
    {
    	$view = new ViewModel();
    	$request = $this->getRequest();
    	$entityManager = $this->getEvent()->getParam("entityManager");
    	 
    	if($request->isPost())
    	{
    		$strUser = $request->getPost()->user;
    		$strProductIds = $request->getPost()->products;
    		$strDescription = $request->getPost()->description;

    		$reporter = $entityManager->find("User", $strUser);
    		$engineer = $entityManager->find("User", $strUser);
    		
    		if (!$reporter || !$engineer) {
    			echo "No reporter and/or engineer found for the input.\n";
    			exit(1);
    		}
    		
    		$bug = new \Bug();
    		$bug->setDescription($strDescription);
    		$bug->setCreated(new \DateTime("now"));
    		$bug->setStatus("OPEN");

    		foreach ($strProductIds AS $productId) {
    			$product = $entityManager->find("Product", $productId);
    			$bug->assignToProduct($product);
    		}
    		
    		$bug->setReporter($reporter);
    		$bug->setEngineer($engineer);
    		
    		$entityManager->persist($bug);
    		$entityManager->flush();
    		
    		$view->setVariable('bug', $bug);
    		$view->setTemplate('application/bug/create_post');
    	}
    	else 
    	{
    		// If you don't have parameters in the query, you can use the getResult() shortcut
    		$users = $entityManager->getRepository('User')->findAll();
    		$view->setVariable('users', $users);
    		
    		$products = $entityManager->getRepository('Product')->findAll();
    		$view->setVariable('products', $products);
    	}
    	 
    	return $view;
    }
    
    public function dashboardAction()
    {
    	$view = new ViewModel();
    	$request = $this->getRequest();
    	$entityManager = $this->getEvent()->getParam("entityManager");
    	
    	if($request->isPost())
    	{
    		$theUserId = $request->getPost()->user;
    		$dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ".
    			"WHERE b.status = 'OPEN' AND (e.id = ?1 OR r.id = ?1) ORDER BY b.created DESC";
    	
    		$myBugs = $entityManager->createQuery($dql)
    		->setParameter(1, $theUserId)
    		->setMaxResults(15)
    		->getResult();
    	
			$view->setVariable('mybugs', $myBugs);    		
    		$view->setTemplate('application/bug/dashboard_post');
    	}
    	else
    	{
    		$users = $entityManager->getRepository('User')->findAll();
    		$view->setVariable('users', $users);
    	}
    	return $view;
    }
    
    public function listAction()
    {
    	$view = new ViewModel();
    	$dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";
    	
    	$entityManager = $this->getEvent()->getParam("entityManager");
    	$query = $entityManager->createQuery($dql);
    	$query->setMaxResults(30);
    	$bugs = $query->getResult();
    	
    	$view->setVariable('bugs', $bugs);
    	
    	return $view;
    }
    
    public function listrepositoryAction()
    {
    	$view = new ViewModel();
    	$entityManager = $this->getEvent()->getParam("entityManager");

    	$bugs = $entityManager->getRepository('Bug')->getRecentBugs();
    	
    	$view->setVariable('bugs', $bugs);
    	return $view;
    }
    
    public function showAction()
    {
    	return new ViewModel();
    }
}
