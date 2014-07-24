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
                'size' => '50',
                'class' => 'form-control',
			],
			'options' => [
				'label' => 'Название альбома',
			],
		]);
		
		$this->add([
			'name' => 'description',
			'attributes' => [
				'type' => 'textarea',
                'cols' => '50',
                'rows' => '3',
                'class' => 'form-control',
			],
			'options' => [
				'label' => 'Описание альбома',
			],
		]);
		
		$this->add([
			'name' => 'photographer',
			'attributes' => [
				'type' => 'text',
                'size' => '50',
                'class' => 'form-control',
			],
			'options' => [
				'label' => 'Имя фотографа',
			],
		]);
		
		$this->add([
			'name' => 'email',
			'attributes' => [
				'type' => 'email',
                'class' => 'form-control',
			],
			'options' => [
				'label' => 'Адрес электронной почты',
			],
		]);
		
		$this->add([
			'name' => 'phone',
			'attributes' => [
				'type' => 'text',
                'class' => 'form-control',
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
                        'options' => [
						    'message' => 'Пожалуйста введите описание альбома',
                        ],
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
                        'options' => [
						    'message' => 'Пожалуйста введите имя фотографа',
                         ],
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
                'required' => false,
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
                'validators' => [
                    [
                        'name' => 'EmailAddress',
                    ],
                ],
			],
			
			'phone' => [
                'required' => false,
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
				'validators' => [
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^\+7\40\(\d{3}\)\40\d{3}\-\d{2}\-\d{2}$/',
                            'messages' => [
                                \Zend\Validator\Regex::NOT_MATCH => 'Номер телефона должен соответствовать формату +7 (xxx) xxx-xx-xx',
                            ],
                        ],
                    ],
				],
			],
		];
	}
}
