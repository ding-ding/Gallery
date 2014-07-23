<?php

namespace Gallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function createAction()
    {
        $form = new \Gallery\Form\CreateAlbum();

        if ($this->getRequest()->isPost()) {
            $form->setHydrator(new \Zend\Stdlib\Hydrator\Reflection());
            $form->bind(new \Gallery\Entity\Album());
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $newAlbum = $form->getData();

                $mapper = $this->getServiceLocator()
                    ->get('Gallery\Mapper\Album');

                $mapper->insert($newAlbum);

                $form = new \Gallery\Form\CreateAlbum();

                return new ViewModel([
                    'form' => $form,
                    'success' => true,
                ]);
            } else {
                return new ViewModel([
                    'form' => $form,
                ]);
            }
        }
        else
            return new ViewModel([
                'form' => $form,
            ]);
    }

    public function editAction()
    {
        return new ViewModel();
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

