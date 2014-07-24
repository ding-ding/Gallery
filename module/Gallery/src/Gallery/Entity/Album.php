<?php

namespace Gallery\Entity;

class Album
{
	/**
	 * Идентификатор альбома
	 * 
	 * @var integer
	 */
    protected $id;
	
	/**
	 * Название альбома
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * Описание альбома 
	 * 
	 * @var string
	 */
	protected $description;
	
	/**
	 * Имя фотографа
	 * 
	 * @var string
	 */
	protected $photographer;
	
	/**
	 * Адрес электронной почты фотографа
	 * 
	 * @var string
	 */
	protected $email;
	
	/**
	 * Номер телефона фотографа
	 * 
	 * @var string
	 */
	protected $phone;
	
	/**
	 * Дата создания альбома
	 * 
	 * @var string
	 */
	protected $creation_date;
	
	/**
	 * Дата изменения информации об альбоме
	 * 
	 * @var string
	 */
	protected $change_date;
	
	/**
	 * Дата и время последней загруженной фотографии
	 * 
	 * @var string
	 */
	protected $last_upload_photo;
	
	/**
	 * Количество фотографий в альбоме
	 * 
	 * @var integer
	 */
	protected $count_photo;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getDescription()
	{
		return $this->description;
	}
	
	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getPhotographer()
	{
		return $this->photographer;
	}
	
	public function setPhotographer($photographer)
	{
		$this->photographer = $photographer;
	}

	public function getEmail()
	{
		return $this->email;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

	public function getCreationDate()
	{
		return $this->creation_date;
	}
	
	public function setCreationDate($creation_date)
	{
		$this->creation_date = $creation_date;
	}

	public function getChangeDate()
	{
		return $this->change_date;
	}
	
	public function setChangeDate($change_date)
	{
		$this->change_date = $change_date;
	}

	public function getLastUploadPhoto()
	{
		return $this->last_upload_photo;
	}
	
	public function setLastUploadPhoto($last_upload_photo)
	{
		$this->last_upload_photo = $last_upload_photo;
	}

	public function getCountPhoto()
	{
		return $this->count_photo;
	}

	public function setCountPhoto($count_photo)
	{
		$this->count_photo = $count_photo;
	}
	
	
}
