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
		
		if (empty($albumId))
			$albumList = $this->getAlbumList();
		else 
			$albumList = [];
	
		$form = new \Gallery\Form\AddPhoto($albumList);
		
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
			
			$albumId = !empty($albumId) ? $albumId : $this->getRequest()->getPost()->album_id;
			
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
				
				$uploadFileName = $this->renameFile($uploadFile['name']);
				$photo->setFile($uploadFileName);
				$this->resizeImage($uploadFileName);
				
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

		/**
		 * Удаление фото из файловой системы
		 */
		$uploadLocation = $this->getFileUploadLocation();
		$fileName = $photoMapper->getFileName($photoId);
		
		unlink($uploadLocation . '/' . $fileName);
		unlink($uploadLocation . '/250_' . $fileName);
		
		/**
		 * Удаление фото из базы
		 */
        $photoMapper->delete('id = ' . $photoId);
		
        $albumMapper->counterDec($albumId);

        if ($countPhoto <= 0)
            $albumMapper->addDateTimeLastPhoto($albumId, null);

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
	
	public function resizeImage($image)
	{
		$uploadLocation = $this->getFileUploadLocation();
		$filePath = $uploadLocation . '/' . $image;
		$pathParts = pathinfo($filePath);
		$fileName = $pathParts['filename'];
		$fileExtension = $pathParts['extension'];

		$size = GetImageSize($filePath);

		$fileExtension = ($fileExtension == 'jpg') ? 'jpeg' : $fileExtension;

		$imageCreateFrom = 'ImageCreateFrom' . $fileExtension;
		$imageSave = 'Image' . $fileExtension;

		$src = $imageCreateFrom($filePath);

		$imageWidth = $size[0];
		$imageHeight = $size[1];

		$k = $imageWidth / 250;

		$newImageHeight = ceil($imageHeight / $k);

		$dst = ImageCreateTrueColor(250, $newImageHeight);

		ImageCopyResampled($dst, $src, 0, 0, 0, 0, 250, $newImageHeight, $imageWidth, $imageHeight);
		$imageSave($dst, $uploadLocation . '/250_' . $pathParts['basename']);
		Imagedestroy($src);
	}
	
	public function renameFile($image)
	{
		$uploadLocation = $this->getFileUploadLocation();
		$filePath = $uploadLocation . '/' . $image;
		$pathParts = pathinfo($filePath);
		$fileExtension = $pathParts['extension'];
		
		$newFileName = uniqid("photo", true) . '.' . $fileExtension;
		
		rename($uploadLocation . '/' . $image, $uploadLocation . '/' . $newFileName);
		
		return $newFileName;
	}
	
	public function getAlbumList()
	{
		$albumMapper = $this->getServiceLocator()
			->get('Gallery\Mapper\Album');
		
		$albums = $albumMapper->fetchAll();
		$albumList = [];
		
		foreach ($albums as $album)
		{
			$albumList[$album->getId()] = $album->getName();
		}
		
		return $albumList;
	}
}

