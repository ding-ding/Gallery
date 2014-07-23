<?php

namespace Gallery\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;

class AlbumFieldset extends Fieldset 
	implements InputFilterProviderInterface
{
	public function __construct()
	{
		parent::__construct('album');
		
		$this->add([
			'name' => 'name',
			'attributes' => [
				'type' => 'text',
			],
			'options' => [
				'label' => 'Название альбома',
			],
		]);
		
		$this->add([
			'name' => 'description',
			'attributes' => [
				'type' => 'text',
			],
			'options' => [
				'label' => 'Описание альбома',
			],
		]);
		
		$this->add([
			'name' => 'photographer',
			'attributes' => [
				'type' => 'text',
			],
			'options' => [
				'label' => 'Имя фотографа',
			],
		]);
		
		$this->add([
			'name' => 'email',
			'attributes' => [
				'type' => 'email',
			],
			'options' => [
				'label' => 'Адрес электронной почты',
			],
		]);
		
		$this->add([
			'name' => 'phone',
			'attributes' => [
				'type' => 'text',
			],
			'options' => [
				'label' => 'Номер телефона',
			],
		]);
	}
	
	public function getInputFilterSpecification()
	{
		return [
			'name' => [
				'required' => true,
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
				'validators' => [
					[
						'name' => 'NotEmpty',
						'options' => [
							'message' => 'Пожалуйста, введите название альбома'
						],
					],
					[
						'name' => 'StringLength',
						'options' => [
							'encoding' => 'UTF-8',
							'max' => 50,
							'message' => 'Название альбома не должно превышать 50 символов',
						],
					],
				],
			],
			
			'description' => [
				'required' => true,
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
				'validators' => [
					[
						'name' => 'NotEmpty',
						'message' => 'Пожалуйста введите описание альбома',
					],
					[
						'name' => 'StringLength',
						'options' => [
							'encoding' => 'UTF-8',
							'max' => 200,
							'message' => 'Описание альбома не должно превышать 200 символов',
						],
					],
				],
			],
			
			'photographer' => [
				'required' => true,
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
				'validators' => [
					[
						'name' => 'NotEmpty',
						'message' => 'Пожалуйста введите имя фотографа',
					],
					[
						'name' => 'StringLength',
						'options' => [
							'encoding' => 'UTF-8',
							'max' => 50,
							'message' => 'Имя фотографа не должно превышать 50 символов',
						],
					],
				],
			],
			
			'email' => [
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
				'validators' => [
					'name' => 'EmailAddress',
					'options' => [
						'message' => 'Введите корректный email',
					],
				],
			],
			
			'phone' => [
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
				'validators' => [
					
				],
			],
		];
	}
}
