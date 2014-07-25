<?php

namespace Gallery\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;

class PhotoFieldset extends Fieldset
	implements InputFilterProviderInterface
{
	public function __construct()
	{
		parent::__construct('photo');
		
		$this->add([
			'name' => 'title',
			'attributes' => [
				'type' => 'text',
				'size' => '50',
				'class' => 'form-control',
			],
			'options' => [
				'label' => 'Заголовок фотографии',
			],
		]);
		
		$this->add([
			'name' => 'address',
			'attributes' => [
				'type' => 'textarea',
				'cols' => '50',
				'rows' => '3',
				'class' => 'form-control',
			],
			'options' => [
				'label' => 'Адрес фотосъемки',
			],
		]);
		
		$this->add([
			'name' => 'file_upload',
			'attributes' => [
				'type' => 'file',
				'class' => 'form-control',
			],
			'options' => [
				'label' => 'Фотография',
			],
		]);
	}
	
	public function getInputFilterSpecification()
	{
		return [
			'title' => [
				'required' => true,
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
				'validators' => [
					[
						'name' => 'NotEmpty',
						'options' => [
							'message' => 'Пожалуйста введите заголовок фотографии',
						],
					],
					[
						'name' => 'StringLength',
						'options' => [
							'encoding' => 'UTF-8',
							'max' => 50,
							'message' => 'Название фотографии не должно превышать 50 символов',
						],
					],
				],
			],
			
			'address' => [
				'required' => false,
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
			],
			
			'file_upload' => [
				'required' => true,
				'filters' => [
					['name' => 'StringTrim'],
					['name' => 'StripTags'],
				],
				'validators' => [
					[
						'name' => 'Zend\Validator\File\Size',
						'options' => [
							'max' => '2MB',
							'message' => 'Изображение не должно весить более 2 мегабайт'
						],
					],
					[
						'name' => 'Zend\Validator\File\IsImage',
					],
					[
						'name' => 'Zend\Validator\File\Extension',
						'options' => [
							'extension' => 'png,jpeg,jpg,gif',
							'message' => 'Изображение должно иметь допустивый формат(png,jpeg,gif)',
						],
					],
				],
			],
		];
	}
}

