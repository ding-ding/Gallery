<?php

namespace Gallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PhotoController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
		$form = new \Gallery\Form\AddPhoto();
		
		if ($this->getRequest()->isPost()) {
			$form->setHydrator(new \Zend\Stdlib\Hydrator\Reflection());
            $form->bind(new \Gallery\Entity\Photo());
            $form->setData($this->getRequest()->getPost());
			
			if ($form->isValid()) {
				
			} else {
				return new ViewModel(['form' => $form,]);
			}
			
		} else {
	        return new ViewModel(['form' => $form,]);
		}
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function viewAction()
    {
        return new ViewModel();
    }


}

