<?php

namespace Gallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{

    public function indexAction()
    {
        $mapper = $this->getServiceLocator()
			->get('Gallery\Mapper\Album');
		
		$albums = $mapper->fetchAll();
		
        return new ViewModel([
			'albums' => $albums,
		]);
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
				
				$date = date('Y-m-d');
				$newAlbum->setCreationDate($date);
				$newAlbum->setChangeDate($date);

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
		$id = (int)$this->params('id');
		
		$form = new \Gallery\Form\EditAlbum();
		
		if ($this->getRequest()->isPost()) {
			$form->setHydrator(new \Zend\Stdlib\Hydrator\Reflection());
            $form->bind(new \Gallery\Entity\Album());
            $form->setData($this->getRequest()->getPost());
			
			$mapper = $this->getServiceLocator()
				->get('Gallery\Mapper\Album');
		
			$albumOld = $mapper->findById($id)->current();
			
			if ($form->isValid()) {
                $album = $form->getData();

                $mapper = $this->getServiceLocator()
                    ->get('Gallery\Mapper\Album');
				
				$album->setId($id);
				$album->setCreationDate($albumOld['creation_date']);
				$album->setChangeDate(date('Y-m-d'));
				$album->setLastUploadPhoto($albumOld['last_upload_photo']);
				$album->setCountPhoto($albumOld['count_photo']);
				
                $mapper->update($album, 'id = ' . $id);
				
				return $this->redirect()->toRoute($this->route, 
					['controller' => 'album'],
					['action' => 'index']
				);
            } else {
				$form->get('album')->get('name')->setValue($albumOld['name']);
				$form->get('album')->get('description')->setValue($albumOld['description']);
				$form->get('album')->get('photographer')->setValue($albumOld['photographer']);
				$form->get('album')->get('email')->setValue($albumOld['email']);
				$form->get('album')->get('phone')->setValue($albumOld['phone']);
				
				return new ViewModel([
					'form' => $form,
				]);
            }
			
		} else {
			$mapper = $this->getServiceLocator()
				->get('Gallery\Mapper\Album');
		
			$album = $mapper->findById($id)->current();
			
			$form->get('album')->get('name')->setValue($album['name']);
			$form->get('album')->get('description')->setValue($album['description']);
			$form->get('album')->get('photographer')->setValue($album['photographer']);
			$form->get('album')->get('email')->setValue($album['email']);
			$form->get('album')->get('phone')->setValue($album['phone']);
			
			return new ViewModel([
				'form' => $form,
			]);
		}
    }

    public function deleteAction()
    {
		$id = (int)$this->params('id');
		
		$mapper = $this->getServiceLocator()
            ->get('Gallery\Mapper\Album');
		
		$mapper->delete('id = ' . $id);
		
		return $this->redirect()->toRoute($this->route, 
			['controller' => 'album'],
			['action' => 'index']
		);
    }

    public function viewAction()
    {
		$id = (int)$this->params('id');
		
		$mapper = $this->getServiceLocator()
			->get('Gallery\Mapper\Album');
		
		$album = $mapper->findById($id)->current();
		
        return new ViewModel([
			'album' => $album,
		]);
    }


}

