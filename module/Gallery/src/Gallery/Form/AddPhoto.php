<?php

namespace Gallery\Form;

use Zend\Form\Form;

class AddPhoto extends Form
{
	public function __construct($albumList = null)
	{
		parent::__construct('addPhoto');
		$this->setAttribute('action', '');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
		$this->setAttribute('role', 'form');
		
		if (!empty($albumList))
		{
			$this->add([
				'name' => 'album_id',
				'type' => '\Zend\Form\Element\Select',
				'attributes' => [
					'class' => 'form-control',
					'value'=>'0',
				],
				'options' => [
					'label' => 'Альбомы',
					'empty_option' => 'Выберите альбом',
					'value_options' => 	$albumList,
				],
			]);
		}
		
		$this->add([
			'type' => 'Gallery\Form\PhotoFieldset',
			'options' => [
				'use_as_base_fieldset' => true,
			],
		]);
		
		$this->add([
			'name' => 'submit',
			'attributes' => [
				'type' => 'submit',
				'value' => 'Сохранить',
				'class' => 'btn btn-primary',
			],
		]);
	}
}