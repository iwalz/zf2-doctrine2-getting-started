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


class UserController extends AbstractActionController
{
    public function createAction()
    {
    	$view = new ViewModel();
    	$request = $this->getRequest();
    	
    	if($request->isPost())
    	{
			$entityManager = $this->getEvent()->getParam("entityManager");
    		
    		$strUser = $request->getPost()->user;
    		$user = new \User();
    		$user->setName($strUser);
    		
    		$entityManager->persist($user);
    		$entityManager->flush();
    		
    		$view->setVariable('user', $user);
			$view->setTemplate('application/user/create_post');
    	}
        return $view;
    }
    
    public function deleteAction()
    {
    	$view = new ViewModel();
    	$request = $this->getRequest();
    	$entityManager = $this->getEvent()->getParam("entityManager");
    	
    	if($request->isPost())
    	{
    		$userId = $request->getPost()->user;
    		$user = $entityManager->find("User", $userId);
    		
    		$dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ".
    			"WHERE (e.id = ?1 OR r.id = ?1) ORDER BY b.created DESC";
    	
    		$bugs = $entityManager->createQuery($dql)
    		->setParameter(1, $userId)
    		->setMaxResults(15)
    		->getResult();
    		
    		foreach($bugs as $bug)
    		{
    			$entityManager->remove($bug);
    		}
    		$entityManager->remove($user);
    		$entityManager->flush();
    		$view->setTemplate('application/user/delete_post');
    	}
    	else
    	{
    		$users = $entityManager->getRepository('User')->findAll();
    		$view->setVariable('users', $users);
    	}
    	
    	return $view;
    }
}
