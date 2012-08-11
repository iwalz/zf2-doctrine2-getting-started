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
    	return new ViewModel();
    }
    
    public function createAction()
    {
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	return new ViewModel();
    }
    
    public function listrepositoryAction()
    {
    	return new ViewModel();
    }
    
    public function showAction()
    {
    	return new ViewModel();
    }
}
