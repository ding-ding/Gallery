<?php

namespace Gallery\Entity;

class Photo
{
	/**
	 * Идентификатор фотографии
	 * 
	 * @var integer
	 */
    protected $id;
    
	/**
	 * Заголовок фотографии
	 * 
	 * @var string
	 */
    protected $title;
    
	/**
	 * Место съемки
	 * 
	 * @var string
	 */
    protected $address;
    
	/**
	 * Путь к файлу фотографии
	 * 
	 * @var string
	 */
    protected $file;
    
	/**
	 * Дата загрузки фотографии
	 * 
	 * @var string
	 */
    protected $upload_date;
    
	/**
	 * Идентификатор альбома, в который загружена фотография
	 * 
	 * @var integer
	 */
    protected $album_id;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getAddress()
    {
        return $this->address;
    }
    
    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getFile()
    {
        return $this->file;
    }
	
    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getUploadDate()
    {
        return $this->upload_date;
    }

	public function setUploadDate($upload_date)
    {
        $this->upload_date = $upload_date;
    }
	
    public function getAlbumId()
    {
        return $this->album_id;
    }

    public function setAlbumId($album_id)
    {
        $this->album_id = $album_id;
    }


}
