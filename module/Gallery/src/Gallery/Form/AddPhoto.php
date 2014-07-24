<?php

namespace Gallery\Form;

use Zend\Form\Form;

class AddPhoto extends Form
{
	public function __construct()
	{
		parent::__construct('addPhoto');
		$this->setAttribute('action', '');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');
		$this->setAttribute('role', 'form');
		
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