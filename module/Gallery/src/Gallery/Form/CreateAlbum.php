<?php

namespace Gallery\Form;

use Zend\Form\Form;

class CreateAlbum extends Form
{
	public function __construct()
	{
		parent::__construct('createAlbum');
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
				'value' => 'Сохранить',
                'class' => 'btn btn-primary',
			],
		]);
	}
}