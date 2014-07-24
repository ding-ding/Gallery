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
		$albumId = (int)$this->params('id');

		$form = new \Gallery\Form\AddPhoto();
		
		if ($this->getRequest()->isPost()) {
			
			$form->setHydrator(new \Zend\Stdlib\Hydrator\Reflection());
            $form->bind(new \Gallery\Entity\Photo());

			$request = $this->getRequest();
			$postArray = $request->getPost()->toArray();
			$fileArray = $this->params()->fromFiles();
			$formData = array_merge_recursive(
				$postArray,
				$fileArray
			);
			
			$form->setData($formData);
			
			if ($form->isValid()) {
				$photo = $form->getData();
				
				$mapper = $this->getServiceLocator()
					->get('Gallery\Mapper\Photo');
				
				$photo->setUploadDate(date('Y-m-d'));
				
				$uploadFile = $fileArray['photo']['file_upload'];

				$uploadPath = $this->getFileUploadLocation();
				
				$fileAdapter = new \Zend\File\Transfer\Adapter\Http();
				$fileAdapter->setDestination($uploadPath);
				
				if ($fileAdapter->receive($uploadFile['name'])) {
                    $albumMapper = $this->getServiceLocator()
                        ->get('Gallery\Mapper\Album');
                    /**
                                         *  Увеличиваем на единицу количество фотографий
                                         */
                    $albumMapper->counterInc($albumId);

                    /**
                                         *  Добавляем в альбом дату и время последней загруженной фотографии
                                         */
                    $albumMapper->addDateTimeLastPhoto($albumId, date('Y-m-d H:i:s'));

                };
				
				$photo->setFile($uploadFile['name']);
				
				$photo->setAlbumId($albumId);
				
				$mapper->insert($photo);

                return $this->redirect()->toRoute('album',
					['action' => 'view', 'id' => $albumId]
				);
				
			} else {
				return new ViewModel(['form' => $form,]);
			}
			
		} else {
	        return new ViewModel(['form' => $form,]);
		}
    }

    public function deleteAction()
    {
        $photoId = (int)$this->params('id');

        $photoMapper = $this->getServiceLocator()
            ->get('Gallery\Mapper\Photo');
        $albumMapper = $this->getServiceLocator()
            ->get('Gallery\Mapper\Album');

        $albumId = $photoMapper->getAlbumId($photoId);
        $countPhoto = $albumMapper->countPhoto($albumId);

        $photoMapper->delete('id = ' . $photoId);

        $albumMapper->counterDec($albumId);

        if ($countPhoto == 0)
            $albumMapper->addDateTimeLastPhoto($albumId, '');

        return $this->redirect()->toRoute('album', [
                'controller' => 'album',
                'action' => 'view',
                'id' => $albumId,
        ]);
    }

    public function viewAction()
    {
        return new ViewModel([
			
		]);
    }

	public function getFileUploadLocation()
	{
		$config = $this->getServiceLocator()->get('Config');
		
		return $config['module_config']['upload_location'];
	}
}

