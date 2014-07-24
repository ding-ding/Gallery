<?php

namespace Gallery\Form;

use Zend\Form\Form;

class EditAlbum extends Form
{
	public function __construct()
	{
		parent::__construct('editAlbum');
		$this->setAttribute('action', '');
		$this->setAttribute('method', 'post');
		$this->setAttribute('role', 'form');
		
		$this->add([
			'type' => 'Gallery\Form\AlbumFieldset',
			'options' => [
				'use_as_base_fieldset' => true,
			],
		]);
		
		$this->add([
			'name' => 'submit',
			'attributes' => [
				'type' => 'submit',
				'value' => 'Обновить',
				'class' => 'btn btn-primary',
			],
		]);
	}
}